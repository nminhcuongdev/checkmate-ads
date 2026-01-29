<?php
namespace App\Repositories\BankReport;

use App\Models\Bank;
use App\Models\Customer;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;


class BankReportRepository extends BaseRepository implements BankReportRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\BankReport::class;
    }

    public function search($paginate = true)
    {
        $banks = Bank::where('admin_id', Auth::guard('admin')->id())->pluck('id');

        if (Auth::guard('admin')->user()->role == 2 ){
            $result = $this->model->select('id', 'bank_id', 'balance', 'date', 'receive', 'transfer', 'refund', 'pay', 'pay_usd')->whereIn('bank_id', $banks);
        } else {
            $result = $this->model->select('id', 'bank_id', 'balance', 'date', 'receive', 'transfer', 'refund', 'pay', 'pay_usd');
        }

        if (request()->get('bank_id')) {
            $result->where('bank_id', request()->get('bank_id'));
        }

        if (request()->get('date')) {
            $result->where('date', request()->get('date'));
        }

        if ($paginate == false){
            return $result->get();
        }

        return $result->paginate(config('const.numPerPage'));
    }
}
