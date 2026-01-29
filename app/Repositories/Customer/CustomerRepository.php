<?php
namespace App\Repositories\Customer;

use App\Repositories\Account\AccountRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\Group\GroupRepositoryInterface;
use App\Repositories\History\HistoryRepositoryInterface;
use App\Repositories\Report\ReportRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Customer::class;
    }

    public function getByAdmin() {
        $result = $this->model->select('id', 'name', 'email', 'balance', 'fee', 'ins_datetime', 'admin_id', 'amount_fee', 'account_id')->where('admin_id', Auth::guard('admin')->user()->id);
        if (request()->get('searchName')) {
            $result->where('name', 'like', '%' . request()->get('searchName') . '%');
        }

        return $result->get();
    }

    public function search($paginate = true)
    {
        $result = $this->model->select('id', 'name', 'nick_name', 'email', 'balance', 'fee', 'ins_datetime', 'amount_fee', 'admin_id', 'account_id')->sortable(['name' => 'asc']);;

        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 2) {
            $result->where('admin_id', Auth::guard('admin')->id());
        }
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 3) {
            $result->where('account_id', Auth::guard('admin')->id());
        }

        if (request()->get('searchName')) {
            $result->where('name', 'like', '%' . request()->get('searchName') . '%');
        }

        if ($paginate == false){
            return $result->get();
        }

        return $result->paginate(config('const.numPerPage'));
    }
}
