<?php
namespace App\Repositories\History;

use App\Models\Customer;
use App\Repositories\BaseRepository;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Report\ReportRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HistoryRepository extends BaseRepository implements HistoryRepositoryInterface
{

    public function getModel()
    {
        return \App\Models\History::class;
    }

    public function search($paginate = true)
    {
        $result = $this->model->select('histories.id', 'customer_id', 'date', 'amount', 'histories.fee', 'hashcode', 'last_balance')->sortable(['id' => 'desc'])->where('histories.ins_datetime', '>=', Carbon::now()->subMonths(2)->startOfMonth());
        if (Auth::guard('customer')->check()) {
            $result->where('customer_id', Auth::guard('customer')->id());
        }

        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 2) {
            $result->withoutGlobalScopes()->join('customers', 'customers.id', '=', 'histories.customer_id')->where('customers.admin_id', Auth::guard('admin')->user()->id)->where('histories.del_flag', config('const.active'));
        }
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 3) {
            $result->withoutGlobalScopes()->join('customers', 'customers.id', '=', 'histories.customer_id')->where('customers.account_id', Auth::guard('admin')->user()->id)->where('histories.del_flag', config('const.active'));
        }

        if (request()->get('customer')) {
            $result->where('customer_id', '=', request()->get('customer'));
        }

        if (request()->get('month')) {
            return $result->whereRaw("MONTH(date) = '".request()->get('month')."'")->paginate(100);
        }

        if ($paginate == false){
            return $result->get();
        }

        return $result->paginate(config('const.numPerPage'));
    }
}
