<?php
namespace App\Repositories\Account;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Report;
use App\Repositories\BaseRepository;
use App\Repositories\Report\ReportRepositoryInterface;
use Carbon\Carbon;
use Cassandra\Custom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{

    private $reportRepo;

    public function __construct(ReportRepositoryInterface $reportRepo)
    {
        $this->reportRepo = $reportRepo;
        parent::__construct();
    }

    public function getModel()
    {
        return \App\Models\Account::class;
    }

    public function search($paginate = true)
    {
        $result = $this->model->select('accounts.id', 'accounts.name', 'code', 'customer_id', 'status', 'limit', 'group', 'currency')->orderBy('group', 'desc');

        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 2) {
            $result->withoutGlobalScopes()->join('customers', 'customers.id', '=', 'accounts.customer_id')->where('admin_id', Auth::guard('admin')->id())->where('accounts.del_flag', config('const.active'));
        }

        if (!blank(request()->get('status'))) {
            $result->where('status', request()->get('status'));
        }

        if (!blank(request()->get('customer'))) {
            $result->where('customer_id', request()->get('customer'))->orderBy('name', 'asc');
        }

        if (Auth::guard('customer')->check()) {
            if (!empty(Auth::guard('customer')->user()->group_id)) {
                $group = Group::find(Auth::guard('customer')->user()->group_id);
                if (empty($group->share_id) || $group->share_id == Auth::guard('customer')->user()->id) {
                    $customers = Customer::where('group_id', Auth::guard('customer')->user()->group_id) ->pluck('id');
                    $result->whereIn('customer_id', $customers)->orderBy('name', 'asc');
                } else {
                    $result->where('customer_id', Auth::guard('customer')->id())->orderBy('name', 'asc');
                }
                $customers = Customer::where('group_id', Auth::guard('customer')->user()->group_id) ->pluck('id');
                $result->whereIn('customer_id', $customers)->orderBy('name', 'asc');
            } else {
                $result->where('customer_id', Auth::guard('customer')->id())->orderBy('name', 'asc');
            }
        }

        if ($paginate == false){
            return $result->get();
        }
        return $result->paginate(30)->withQueryString();
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->update($id, ['del_flag' => config('const.deleted')]);
            $reports = Report::where('account_id', $id)->get();
            foreach ($reports as $report) {
                $this->reportRepo->delete($report->id);
            }
            DB::commit();
        } catch (\Exception $ex){
            dd($ex->getMessage());
            DB::rollBack();
        }
    }
}
