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
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Fee</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            ${{ sprintf("%.2f",$customers->sum('amount_fee')) }}
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
        <div class="row g-4">
            <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <canvas id="chart3" style="max-height: 450px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <canvas id="chart1" style="height: 450px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <canvas id="chart2" style="height: 450px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <canvas id="chart4" style="height: 450px"></canvas>
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
                    <a href="{{ route('management.home') }}" type="submit" class="btn btn-sm btn-primary">Clear</a>
                </div>
            </div>
        </form>

        <table id="myTable" class="stripe row-border order-column" width="100%">
            <thead>
            <tr class="text-dark">
                <th>Customer</th>
                <th>Tech</th>
                <th>Account</th>
                <th>Balance</th>
                <th>Fee</th>
                @for($i = 6; $i >= 0; $i--)
                    @php
                        $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d",request('searchDate')) : \Carbon\Carbon::today();
                    @endphp
                     <th>{{ $day->subDay($i)->format('d/m') }}</th>
                @endfor
                <th>Total Month</th>
            </tr>
            @php
                $start = \Carbon\Carbon::now()->startOfMonth();
                $end = \Carbon\Carbon::now()->endOfMonth();
                $dates = [];
                while ($start->lte($end)) {
                     $dates[] = $start->copy();
                     $start->addDay();
                }
            @endphp
            <tr>
                <td colspan="3">Total</th>
                <td><b id="total3"></b></th>
                <td><b id="total4"></b></th>
                <td><b id="total5"></b></th>
                <td><b id="total6"></b></th>
                <td><b id="total7"></b></th>
                <td><b id="total8"></b></th>
                <td><b id="total9"></b></th>
                <td><b id="total10"></b></th>
                <td><b id="total11"></b></th>
                <td><b id="total12">0</b></th>
            </tr>
            </thead>
            <tbody>

            @foreach($customers as $customer)
                <tr>
                    <td><a href="{{ route('management.account', ['customer' => $customer->id]) }}">{{ $customer['name'] }}</a></td>
                    <td>@if(!empty($customer->admin)) {{ $customer->admin->name }} @endif</td>
                    <td>@if(!empty($customer->account)) {{ $customer->account->name }} @endif</td>
                    <td>{{ sprintf("%.2f",  $customer['balance']) }}</td>
                    <td>{{ sprintf("%.2f",  $customer['amount_fee']) }}</td>
                    @for($i = 6; $i >= 0; $i--)
                        @php
                            $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d",request('searchDate')) : \Carbon\Carbon::today();
                            $daySeach = $day->subDay($i)->format("Y-m-d");
                        @endphp
                        @if($customer->customerReports->where('date', $daySeach)->first() && $customer->customerReports->where('date', $daySeach)->first()->spent != 0)
                            <td style="color: #f8b600; font-weight: bold"> {{ sprintf("%.2f", $customer->customerReports->where('date', $daySeach)->first()->spent) }} </td>
                        @else <td>0</td> @endif</td>
                    @endfor
                    <td>{{ sprintf("%.2f", $customer->customerReports->whereBetween('date', [$dates[0]->format('Y-m-d'), end($dates)->format('Y-m-d')])->sum('spent')) }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css">
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-stacked100@1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/fixedHeader.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.js"></script>

    <script>
        $(document).ready(function(){
            new DataTable('#myTable', {
                footerCallback: function (row, data, start, end, display) {
                    let api = this.api();
                    // Remove the formatting to get integer data for summation
                    let intVal = function (i) {
                        return typeof i === 'string'
                            ? i * 1
                            : typeof i === 'number'
                                ? i
                                : 0;
                    };

                    for (let i = 3; i < 13; i++) {
                        $("#total"+i).html(api
                            .column(i, {search: 'applied' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0).toFixed(2));
                    }
                },
                fixedColumns: {
                    start: 3,
                    end: 1
                },
                fixedHeader: true,
                scrollCollapse: true,
                scrollX: true,
                scrollY: 450,
                layout: {
                    topStart: 'search',
                    topEnd: 'pageLength',
                    bottomStart: 'info',
                    bottomEnd: 'paging',
                },
            });
        });
    </script>

    <script>

        // Chart 1
        Chart.defaults.font.size = 20;
        Chart.register(ChartjsPluginStacked100.default);

        new Chart("chart1", {
            type: "bar",
            data: {
                labels: @json($data['chart1']['label']),
                datasets: [
                    {
                        label: 'Live',
                        backgroundColor: '#F8D241',
                        borderColor:  '#F8D241',
                        borderWidth: 1,
                        data: @json($data['chart1']['totalLives']),
                    },
                    {
                        label: 'Die',
                        backgroundColor: '#D3D3D3',
                        borderColor: '#D3D3D3',
                        borderWidth: 1,
                        data: @json($data['chart1']['totalDies']),
                    }, ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Account Live / Die'
                    },
                    stacked100: {
                        enable: true
                    }
                },
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        ticks: {
                            callback: function(label, index, labels) {
                                return label+'%';
                            }
                        },
                        stacked: true
                    }
                }
            }
        });

        // Chart 2
        var labels = ["Spent Account", "Account Live"];
        var barColors = [
            '#F8D241',
            '#D3D3D3',
        ];

        new Chart("chart2", {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    backgroundColor: barColors,
                    data: @json($data['chart2']['value'])
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: "Spent Account / Account Live"
                    },
                    datalabels: {
                        formatter: ((value, ctx) => {
                            const totalSum = ctx.dataset.data.reduce((accumulator, currentValue) => {
                                return accumulator + currentValue
                            }, 0);
                            const percentage = value / totalSum * 100;
                            return `${percentage.toFixed(1)}%`;
                        })
                    }
                },
                responsive: true,
            },
            plugins: [ChartDataLabels]
        });

        // Chart 3


        new Chart("chart3", {
            type: "bar",
            data: {
                labels: @json($data['chart3']['label']),
                datasets: [{
                    backgroundColor: '#F8D241',
                    data: @json($data['chart3']['value'])
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: function(label, index, labels) {
                                return '$'+label;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {display: false},
                    title: {
                        display: true,
                        text: "Amount Spend / Day"
                    },
                },
                responsive: true,
            }
        });
        // Chart 4
        var labels = ["Total Spend", "Total Top Up"];
        new Chart("chart4", {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    backgroundColor: barColors,
                    data: @json($data['chart4']['value'])
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: "Total Top Up / Total Spend"
                    },
                    datalabels: {
                        formatter: ((value, ctx) => {
                            const totalSum = ctx.dataset.data.reduce((accumulator, currentValue) => {
                                return parseFloat(accumulator) + parseFloat(currentValue)
                            }, 0);
                            const percentage = parseFloat(value) / totalSum * 100;
                            return `${percentage.toFixed(1)}%`;
                        })
                    }
                },
                responsive: true,
            },
            plugins: [ChartDataLabels]
        });
    </script>
    <style>
        th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            width: 800px;

            margin: 0 auto;
        }
        #myTable_wrapper {
            padding-bottom: 20px;
        }
    </style>
@endsection

