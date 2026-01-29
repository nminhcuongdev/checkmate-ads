<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\CustomerReport;
use App\Models\History;
use App\Models\Report;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Report\ReportRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $customerRepo;
    protected $reportRepo;

    public function __construct(CustomerRepositoryInterface $customerRepo, ReportRepositoryInterface $reportRepo)
    {
        $this->customerRepo = $customerRepo;
        $this->reportRepo = $reportRepo;
    }

    public function dashboard() {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 2) {
            $customers = $this->customerRepo->getByAdmin();
        } else {
            $customers = $this->customerRepo->search(false);
        }

        if (\request()->get('searchDate')) {
            $currentMonth = \Carbon\Carbon::createFromFormat("Y-m-d",request('searchDate'))->month;
        } else {
            $currentMonth = Carbon::now()->month;

        }

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfMonthFormat = $startOfMonth->format('Y-m-d');
        $endOfMonthFormat = $endOfMonth->format('Y-m-d');
        $today = Carbon::yesterday()->format('Y-m-d');
        $dates = [];
        $monthSpent = [];

        $lastSevenDays = [];
        $totalLives = [];
        $totalDies = [];


        while ($startOfMonth->lte($endOfMonth)) {
            array_push($dates, $startOfMonth->format('d/m'));
            array_push($monthSpent, CustomerReport::where('date', $startOfMonth->format('Y-m-d'))->sum('spent'));
            $startOfMonth->addDay();
        }

        for($i = 6; $i >= 0; $i--) {
            $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d", request('searchDate')) : \Carbon\Carbon::today();
            $subDay = $day->subDay($i);
            $customerReport = CustomerReport::where('date', $subDay->format('Y-m-d'));
            array_push($totalLives, $customerReport->sum('totalLive'));
            array_push($totalDies, $customerReport->sum('totalDie'));
            array_push( $lastSevenDays, $subDay->format('d/m'));
        }

        $totalAccountSpend = Account::where('last_spend', $today)->count();
        $totalAccountLive = Account::where('status', '0')->count();
        $spentOfUnspent = [$totalAccountSpend, $totalAccountLive];
//        dd(CustomerReport::whereBetween('date', [$startOfMonthFormat, $endOfMonthFormat])->sum('spent'), History::whereBetween('date', [$startOfMonthFormat, $endOfMonthFormat])->sum('amount'));
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
                'value' => [CustomerReport::whereBetween('date', [$startOfMonthFormat, $endOfMonthFormat])->sum('spent'), Customer::sum('balance')]
            ],
        ];
        $reports = Report::whereRaw("MONTH(date) = $currentMonth")->get();
        return view("management.dashboard", ['customers' => $customers, 'reports' => $reports, 'data' => $data]);
    }

    public function realSpend() {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 2) {
            $customers = $this->customerRepo->getByAdmin();
        } else {
            $customers = $this->customerRepo->getAll(false);
        }
        $currentMonth = Carbon::now()->month;
        $reports = Report::whereRaw("MONTH(date) = $currentMonth")->get();
        return view("management.realSpend", ['customers' => $customers, 'reports' => $reports]);
    }
}
