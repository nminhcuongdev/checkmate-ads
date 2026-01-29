<?php

namespace App\Http\Controllers\Customer;

use App\Models\Account;
use App\Models\Customer;
use App\Models\CustomerReport;
use App\Models\Group;
use App\Models\History;
use App\Models\Report;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Http\Requests\Customer\UpdateProfileRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class HomeController extends Controller
{
    public $customerRepo;
    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function dashboard() {
        $customerId = Auth::guard('customer')->id();
        $customer = $this->customerRepo->find($customerId);
        $projects = [];
        $customers = [];
        if (!empty($customer->group_id)) {

            $group = Group::find($customer->group_id);
            if (empty($group->share_id) || $group->share_id == $customer->id) {
                $projects = Customer::where('group_id', $customer->group_id)->get();
                $customers = Customer::where('group_id', $customer->group_id)->pluck('id')->toArray();
            } else {
                $customers = [$customerId];
            }
        } else {
            $customers = [$customerId];
        }

        if (\request()->get('date')) {
            $currentMonth = \Carbon\Carbon::createFromFormat("Y-m-d",request('date'))->month;
        } else {
            $currentMonth = Carbon::now()->month;
        }

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfMonthFormat = $startOfMonth->format('Y-m-d');
        $endOfMonthFormat = $endOfMonth->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');
        $dates = [];
        $monthSpent = [];

        $lastSevenDays = [];
        $totalLives = [];
        $totalDies = [];

        while ($startOfMonth->lte($endOfMonth)) {
            array_push($dates, $startOfMonth->format('d/m'));
            array_push($monthSpent, CustomerReport::whereIn('customer_id', $customers)->where('date', $startOfMonth->format('Y-m-d'))->sum('spent'));
            $startOfMonth->addDay();
        }
        for($i = 6; $i >= 0; $i--) {
            $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d", request('searchDate')) : \Carbon\Carbon::today();
            $subDay = $day->subDay($i);
            $customerReport = CustomerReport::whereIn('customer_id', $customers)->where('date', $subDay->format('Y-m-d'));
            array_push($totalLives, $customerReport->sum('totalLive'));
            array_push($totalDies, $customerReport->sum('totalDie'));
            array_push( $lastSevenDays, $subDay->format('d/m'));
        }

        $totalAccountSpend = Account::whereIn('customer_id', $customers)->where('last_spend', $today)->count();
        $totalAccountLive = Account::whereIn('customer_id', $customers)->where('status', '0')->count();
        $spentOfUnspent = [$totalAccountSpend, $totalAccountLive];
        $data = [
            'chart1' => [
                'label' => $lastSevenDays,
                'totalLives' => $totalLives,
                'totalDies' => $totalDies
            ],
            'chart2' => [
                'value' => $spentOfUnspent
            ],
            'chart3' => [
                'label' => $dates,
                'value' => $monthSpent
            ],
            'chart4' => [
                'value' => [CustomerReport::whereBetween('date', [$startOfMonthFormat, $endOfMonthFormat])->whereIn('customer_id', $customers)->sum('spent'), Customer::whereIn('id', $customers)->sum('balance')]
            ],
        ];

//        dd($data);

        if (empty($projects)) {
            array_push($projects, $customer);
        }
        return view("customer.dashboard", ['customer' => $customer, 'customers' => $projects, 'data' => $data]);
    }

    public function profile() {
        $customer = Auth::guard('customer')->user();
        if (!empty($customer)){
            return view("customer.profile", ['customer' => $customer]);
        }
        return redirect()->route('customer.home', ['customer' => $customer]);
    }

    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        try {
            DB::beginTransaction();
            $data = request()->all();
            if (request()->get('password') == null) {
                $data = Arr::except($data, 'password');
            }
            $result = $this->customerRepo->update($data['id'], $data);
            if (!empty($result)) {
                session()->flash('success', __('messages.customerUpdated'));
            }
            DB::commit();
        } catch (Exception $e) {
            dd($e);
            Log::error('Update customer Error ', ['admin_id' => Auth::guard('customer')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.updateFail'));
        }
        return redirect()->route('customer.profile');
    }
}
