<?php

namespace App\Exports;

use App\Exports;
use App\Models\Account;
use App\Models\Customer;
use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class AccountsExport implements FromView
{
    public function __construct($date, $id)
    {
        $this->id = $id;
        $this->date = $date;
    }

    public function view(): View
    {
        $customerId = Auth::guard('customer')->id();
        $customer = app(CustomerRepositoryInterface::class)->find($customerId);
        $customers = [];
        if ( !empty($customer->group_id)) {
            $customers = Customer::where('group_id', $customer->group_id)->pluck('id')->toArray();
        }

        if (!empty($customers)) {
            $accounts = Account::whereIn('customer_id', $customers)->get();
        } else {
            $accounts = Account::where(['customer_id' => $this->id])->get();
        }

        return view('customer.export.accounts', [
            'month' => $this->date,
            'accounts' => $accounts
        ]);
    }
}
