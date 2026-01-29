<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\AccountReport;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerReport;
use App\Models\Group;
use App\Models\LiveDie;
use App\Models\Report;
use App\Repositories\Account\AccountRepository;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ReportsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function __construct($date, $isCalculate, $rates)
    {
        $this->date = $date;
        $this->rate = $rates;
        $this->isCalculate = $isCalculate;
        $this->exchangeRates = app(ExchangeRate::class);
    }


    public function collection(Collection $rows)
    {
//        $rates = Currency::all()->pluck('rate', 'code')->toArray();
//        Account::query()->update(['status' => '1']);

        foreach ($rows as $row)
        {
            $accountRepo = app((AccountRepository::class));
            $account = Account::where('name', $row['account_name'])->get()->first();
            if($row['limit'] == 'No limit') {
                $row['limit'] = 10000;
            }

            $customerName = substr($row['account_name'], 0, strpos($row['account_name'], "_"));

            $haveCustomer = Customer::where('name', $customerName)->get()->first();
            if($haveCustomer){
                $haveCustomerReport = CustomerReport::where([
                    'customer_id' => $haveCustomer->id,
                    'date' => $this->date
                ])->first();

                if (!$haveCustomerReport) {
                    $haveCustomerReport = CustomerReport::create([
                        'customer_id' => $haveCustomer->id,
                        'date' => $this->date,
                        'spent' => 0,
                        'totalLive' => 0,
                        'totalDie' => 0,
                        'ins_datetime' => date('Y-m-d H:i:s'),
                        'ins_id' => Auth::guard('admin')->id()
                    ]);
                }

                if ($this->getStatus($row['status']) == 0) {
                    $haveCustomerReport->update(['totalLive' => ++$haveCustomerReport->totalLive]);
                }

                if ($this->getStatus($row['status']) == 1) {
                    $haveCustomerReport->update(['totalDie' => ++$haveCustomerReport->totalDie]);
                }
                
                if ($row['spend'] == '0') {
                    continue;
                }


//                if (!empty($account) && $account->customer_id != $haveCustomer->id) {
//                    die("Check lại account ". $account->name . " đang thuộc về customer " .$account->customer->name . " chứ không phải của customer " . $haveCustomer->name);
//                }
                if (!empty($haveCustomer->group_id)){
                    $group = Group::find($haveCustomer->group_id);
                    if (!empty($group->customer_id)) {
                        $haveCustomer = Customer::find($group->customer_id);
                    }
                }
                try {
                    $currency = substr($row['currency'], 0, strpos($row['currency'], "_"));
                    (double)$amount = $row['spend'] / $this->rate[$currency];
                    (double)$unpaid = $row['unpaid'] / $this->rate[$currency];

                    if (!empty($account)) {
                        $haveAccountReport = AccountReport::where([
                            'account_id' => $account->id,
                            'date' => $this->date
                        ])->first();

                        if (!$haveAccountReport) {
                            $haveAccountReport = AccountReport::create([
                                'account_id' => $account->id,
                                'date' => $this->date,
                                'spent' => 0,
                                'live' => 0,
                                'ins_datetime' => date('Y-m-d H:i:s'),
                                'ins_id' => Auth::guard('admin')->id()
                            ]);
                        }

//                        if ($row['limit'] == 'No limit') {
//                            $limit = 9999;
//                        } else {
//                            $limit = $row['limit'];
//                        }

                        $account->update(['customer_id' => $haveCustomer->id, 'limit' => $row['limit'], 'status' => $this->getStatus($row['status']), 'currency' => $currency]);

                        if (!$row['spend'] == 0) {
                            $account->update(['last_spend' => $this->date]);
                        }

                        $report = Report::where([
                            'account_id' => $account->id,
                            'date' => $this->date,
                        ])->first();

//                        $today = Carbon::createFromFormat('Y-m-d',  $this->date);
//                        $yesterday = $today->subDay();
//                        $yesterdayReport = Report::where([
//                            'account_id' => $account->id,
//                            'date' => $yesterday->format('Y-m-d'),
//                        ])->first();
//
//                        if (!empty($yesterdayReport && !empty($this->isCalculate))) {
//                            if ($yesterdayReport->unpaid == $unpaid && $amount == 0) {
//                                $realSpend = 0;
//                            } else {
//                                $realSpend = $yesterdayReport->unpaid + $yesterdayReport->amount + $amount - $unpaid;
//                            }
//
//                            $yesterdayReport->update(['real_spend' => $realSpend]);
//                        }

                        if (!empty($report)) {
                            $oldAmount = $report->getOriginal('amount');

                            $update = ['amount' => $amount, 'upd_datetime' => date('Y-m-d H:i:s'),
                                'upd_id' => Auth::guard('admin')->id()];

                            if (!empty($this->isCalculate)) {
                                $update = array_merge($update, ['unpaid' => $unpaid]);
                            }

                            $report->update($update);
                            $newAmount = $amount - $oldAmount;

                            $report->update([
                                'amount' => $amount,
                            ]);

                            // Update AccountReport, CustomerReport
                            $haveCustomerReport->update(['spent' => $haveCustomerReport->spent + $newAmount]);
                            $haveAccountReport->update(['spent' => $haveAccountReport->spent + $newAmount]);

                            $haveCustomer->update(['balance' => $haveCustomer->balance - $newAmount]);
                        } else {
                            $amountFee = $amount * ($haveCustomer->fee / 100);
                            $report = Report::create([
                                'account_id' => $account->id,
                                'date' => $this->date,
                                'unpaid' => $unpaid,
                                'amount' => $amount,
                                'currency' => $currency,
                                'limit' => $row['limit'],
                                'ins_datetime' => date('Y-m-d H:i:s'),
                                'ins_id' => Auth::guard('admin')->id()
                            ]);

                            // Update AccountReport, CustomerReport
                            $haveCustomerReport->update(['spent' => $haveCustomerReport->spent + $amount]);
                            $haveAccountReport->update(['spent' => $haveAccountReport->spent + $amount]);
                            $haveCustomer->update(['balance' => $haveCustomer->balance - $amount]);
                        }
                    } else {
                        if (!$row['spend'] == 0) {
                            $lastSpent = $this->date;
                        } else {
                            $lastSpent = null;
                        }

                        $account = $accountRepo->create([
                            'code' => substr($row['account_code'], strpos($row['account_code'], "_") + 1),
                            'name' => $row['account_name'],
                            'customer_id' => $haveCustomer->id,
                            'status' => $this->getStatus($row['status']),
                            'last_spend' => $lastSpent,
                            'currency' => $currency,
                            'limit' => $row['limit']
                        ]);

                        $report = Report::where([
                            'account_id' => $account->id,
                            'date' => $this->date,
                        ])->first();

                        if ($report !== null) {
                            $oldAmount = $report->getOriginal('amount');
                            $report->update(['amount' => $amount, 'upd_datetime' => date('Y-m-d H:i:s'),
                                'upd_id' => Auth::guard('admin')->id()]);
                            $newAmount = $amount - $oldAmount;
                            $report->update([
                                'amount' => $amount
                            ]);

                            $haveCustomerReport->update(['spent' => $haveCustomerReport->spent + $newAmount]);
                            $haveAccountReport = AccountReport::create([
                                'account_id' => $account->id,
                                'date' => $this->date,
                                'spent' => $newAmount,
                                'ins_datetime' => date('Y-m-d H:i:s'),
                                'ins_id' => Auth::guard('admin')->id()
                            ]);
                            $haveCustomer->update(['balance' => $haveCustomer->balance - $newAmount]);
                        } else {
                            $amountFee = $amount * ($haveCustomer->fee / 100);
                            $report = Report::create([
                                'account_id' => $account->id,
                                'date' => $this->date,
                                'unpaid' => $unpaid,
                                'amount' => $amount,
                                'currency' => $currency,
                                'limit' => $row['limit'],
                                'ins_datetime' => date('Y-m-d H:i:s'),
                                'ins_id' => Auth::guard('admin')->id()
                            ]);
                            $haveAccountReport = AccountReport::create([
                                'account_id' => $account->id,
                                'date' => $this->date,
                                'spent' => $amount,
                                'ins_datetime' => date('Y-m-d H:i:s'),
                                'ins_id' => Auth::guard('admin')->id()
                            ]);
                            $haveCustomerReport->spent = $haveCustomerReport->spent + $amount;
                            $haveCustomerReport->save();
                            $haveCustomer->update(['balance' => $haveCustomer->balance - $amount]);
                        }
                    }

                } catch (\Exception $exception){
                    Log::error('Report Create Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $exception->getMessage()]);
                }
            }
        }
    }

    public function prepareForValidation($data, $index)
    {
        $data['customer_name'] = substr($data['account_name'], 0, strpos($data['account_name'], "_"));
        return $data;
    }

    public function customValidationMessages()
    {
        return [

        ];
    }

    public function rules(): array
    {
        return [

        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    function getStatus($status)
    {
        switch ($status) {
            case "Active":
                return 0;
            case "Disabled":
                return 1;
            case "Past due":
                return 1;
            default:
                return 0;
        }
    }
}
