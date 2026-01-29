@php
    $currentMonth = \Carbon\Carbon::now()->month;
@endphp
@extends('layouts.main')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            @if (Session::has('success'))
                <div class="alert alert-success" style="text-align: center;">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Balance</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            ${{ sprintf("%.2f", $customers->sum('balance')) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Customer</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $customers->count() }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Spend Month</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            ${{ sprintf("%.2f",$reports->sum('amount')) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Fee Month</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            ${{ sprintf("%.2f",$reports->sum('amount_fee')) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <form action="" method="get">
            <div class="col-4 col-xl-4">
                <div class="form-floating mb-3">
                    <input type="date" class="form-control"
                           name="searchDate" value="{{ request('searchDate') }}" >
                    <label for="floatingInput">Date</label>
                </div>
            </div>
            <div class="col-3 col-xl-3">
                <div class="form-floating mb-3">
                    <input type="submit" class="btn btn-sm btn-primary" value="Search">
                </div>
            </div>
        </form>
        <div class="bg-light text-center rounded p-4">
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered mb-0 table-striped">
                    <thead>
                    <tr class="text-dark">
                        <th scope="col">Customer name</th>
                        @for($i = 6; $i >= 0; $i--)
                            @php
                                $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d",request('searchDate')) : \Carbon\Carbon::today();
                            @endphp
                            <th scope="col">{{ $day->subDay($i)->format('d/m') }}</th>
                        @endfor
                        <th scope="col">Total Real Spend Month</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><b>Total</b></td>
                        @for($i = 6; $i >= 0; $i--)
                            @php
                                $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d",request('searchDate')) : \Carbon\Carbon::today();
                                    $totalAmountDay = \App\Models\Account::withoutGlobalScopes()->join('reports', 'reports.account_id', '=', 'accounts.id')
                                    ->join('customers', 'customers.id', '=', 'accounts.customer_id')
                                    ->where('reports.date', '=', $day->subDay($i)->format("Y-m-d"))->where('accounts.del_flag', '=', config('const.active'))
                                    ->groupBy('accounts.id')
                                    ->get(['accounts.id', \Illuminate\Support\Facades\DB::raw('sum(reports.real_spend) as real_spend')])
                                    ->sum('real_spend');
                            @endphp
                            <td><b>{{ sprintf("%.2f",  $totalAmountDay) }}</b></td>

                        @endfor
                        @php
                            $totalAmountCustomerMonth = \App\Models\Account::withoutGlobalScopes()->join('reports', 'reports.account_id', '=', 'accounts.id')
                            ->join('customers', 'customers.id', '=', 'accounts.customer_id')
                            ->whereRaw("MONTH(date) = $currentMonth")->where('accounts.del_flag', '=', config('const.active'))
                            ->groupBy('accounts.id')
                            ->get(['accounts.id', \Illuminate\Support\Facades\DB::raw('sum(reports.real_spend) as real_spend')])
                            ->sum('real_spend');
                        @endphp
                        <td><b>{{ sprintf("%.2f", $reports->sum('real_spend')) }}</b></td>
                    </tr>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer['name'] }}</td>
                            @for($i = 6; $i >= 0; $i--)
                                @php
                                    $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d",request('searchDate')) : \Carbon\Carbon::today();
                                        $totalAmount = \App\Models\Account::withoutGlobalScopes()->join('reports', 'reports.account_id', '=', 'accounts.id')
                                    ->join('customers', 'customers.id', '=', 'accounts.customer_id')
                                    ->where('reports.date', '=', $day->subDay($i)->format("Y-m-d"))->where('accounts.del_flag', '=', config('const.active'))
                                    ->where('accounts.customer_id', '=', $customer->id)
                                    ->groupBy('accounts.id')
                                    ->get(['accounts.id', \Illuminate\Support\Facades\DB::raw('sum(reports.real_spend) as real_spend')])
                                    ->sum('real_spend');
                                @endphp
                                <td>{{ sprintf("%.2f",  $totalAmount) }}</td>
                            @endfor
                            @php
                                $totalAmountMonth = \App\Models\Account::withoutGlobalScopes()->join('reports', 'reports.account_id', '=', 'accounts.id')
                                ->join('customers', 'customers.id', '=', 'accounts.customer_id')
                                ->whereRaw("MONTH(date) = $currentMonth")->where('accounts.del_flag', '=', config('const.active'))
                                ->where('accounts.customer_id', '=', $customer->id)
                                ->groupBy('accounts.id')
                                ->get(['accounts.id', \Illuminate\Support\Facades\DB::raw('sum(reports.real_spend) as real_spend')])
                                ->sum('real_spend');
                            @endphp
                            <td>{{ sprintf("%.2f",  $totalAmountMonth) }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                <div class="d-flex align-items-center justify-content-center mt-4">--}}
{{--                    {{ $customers->links() }}--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

