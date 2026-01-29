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
                    <div class="card-body p-3" onclick="showBalance()">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Balance</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        @php
                                            $totalBalance = 0;

                                            if (!empty($customers)) {
                                                foreach ($customers as $project) {
                                                    $totalBalance += $project->balance;
                                                }
                                            } else {
                                                $totalBalance = $customer->balance;
                                            }

                                        @endphp
                                        ${{ sprintf("%.2f", $totalBalance) }}
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
                    <div class="card-body p-3" onclick="showBalance()">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Account</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        @php
                                            $totalAccount = 0;
                                            if (!empty($customers)) {
                                                foreach ($customers as $project) {
                                                $totalAccount += $project->accounts->count();
                                                }
                                            } else {
                                                $totalAccount = $customer->accounts->count();
                                            }

                                        @endphp
                                        {{$totalAccount}}
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
                    <div class="card-body p-3" onclick="totalSpent()">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold" id="totalSpend">Total Spend Month</p>
                                    @php
                                        $spentDay = 0;
                                        $spentWeek = 0;
                                        $spentMonth = 0;
                                        $startOfWeak =  \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d');
                                        $endOfWeak =  \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d');
                                         $startOfMonth =  \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
                                            $endOfMonth =  \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
                                        foreach ($customers as $customer) {
                                            $spentDay += $customer->customerReports->where('date', \Carbon\Carbon::now()->format('Y-m-d'))->sum('spent');
                                            $spentWeek += $customer->customerReports->whereBetween('date', [$startOfWeak, $endOfWeak])->sum('spent');
                                            $spentMonth += $customer->customerReports->whereBetween('date', [$startOfMonth, $endOfMonth])->sum('spent');
                                        }
                                    @endphp
                                    <h5 id="spentDay" style="display: none" class="font-weight-bolder mb-0">
                                        {{ sprintf("%.2f", $spentDay) }}
                                    </h5>
                                    <h5 id="spentWeek" style="display: none" class="font-weight-bolder mb-0">
                                        {{ sprintf("%.2f", $spentWeek) }}
                                    </h5>
                                    <h5 id="spentMonth" class="font-weight-bolder mb-0">
                                        {{ sprintf("%.2f", $spentMonth) }}
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


    <div class="modal fadeOut" tabindex="-1" role="dialog" id="balanceModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Projects Detail</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-striped mb-0">
                            <thead>
                            <tr>
                                <th>Project</th>
                                <th>Balance</th>
                                <th>Account</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $project)
                                <tr>
                                    <td>
                                        {{ $project->name }}
                                    </td>
                                    <td>{{ sprintf("%.2f", $project->balance) }}</td>
                                    <td>{{ $project->accounts->count() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="hideBalance()" type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="btnCloseBalance">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fadeOut" tabindex="-1" role="dialog" id="totalModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choose Total Type</h5>

                </div>
                <div class="modal-body text-center">
                        <button style="margin: 10px" onclick="totalDay()" type="button" class="btn btn-sm btn-primary" data-dismiss="modal"
                                id="btnCloseBalance">Day
                        </button>
                        <button style="margin: 10px" onclick="totalWeek()" type="button" class="btn btn-sm btn-primary" data-dismiss="modal"
                                id="btnCloseBalance">Week
                        </button>
                        <button style="margin: 10px" onclick="totalMonth()" type="button" class="btn btn-sm btn-primary" data-dismiss="modal"
                                id="btnCloseBalance">Month
                        </button>
                </div>
                <div class="modal-footer">
                    <button onclick="hideTotal()" type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="btnCloseBalance">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <form action="" method="get">
            <div class="row">
                <div class="col-3 col-xl-3">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control"
                               placeholder="Name" name="searchDate" value="{{ request()->get('searchDate') }}">
                        <label for="floatingInput">Date</label>
                    </div>
                </div>
                <div class="col-3 col-xl-3 d-flex">
                    <div class="form-floating m-3">
                        <input type="submit" class="btn btn-sm btn-primary" value="Search">
                    </div>
                    <div class="form-floating m-3">
                        <a href="{{ route('customer.home') }}" type="submit" class="btn btn-sm btn-primary">Clear</a>
                    </div>
                </div>
            </div>
        </form>
        @php
            $start = \Carbon\Carbon::now()->startOfMonth();
            $end = \Carbon\Carbon::now()->endOfMonth();
            $dates = [];
            while ($start->lte($end)) {
                 $dates[] = $start->copy();
                 $start->addDay();
            }

        @endphp
        <table id="myTable" class="stripe row-border order-column" width="100%">
            <thead>
                <tr class="text-dark">
                    <th>Project</th>
                    <th>Balance</th>
                    @for($i = 6; $i >= 0; $i--)
                        @php
                            $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d",request('searchDate')) : \Carbon\Carbon::today();
                        @endphp
                        <th>{{ $day->subDay($i)->format('d/m') }}</th>
                    @endfor
                    <th>Total Amount Month</th>
                </tr>
                <tr class="text-dark">
                    <td>Total</td>
                    <td><b id="total1"></b></th>
                    <td><b id="total2"></b></th>
                    <td><b id="total3"></b></th>
                    <td><b id="total4"></b></th>
                    <td><b id="total5"></b></th>
                    <td><b id="total6"></b></th>
                    <td><b id="total7"></b></th>
                    <td><b id="total8"></b></th>
                    <td><b id="total9"></b></th>
                </tr>
            </thead>
            <tbody>
            @php
                $start = \Carbon\Carbon::now()->startOfMonth();
                $end = \Carbon\Carbon::now()->endOfMonth();
                $dates = [];
                while ($start->lte($end)) {
                     $dates[] = $start->copy();
                     $start->addDay();
                }
            @endphp
            @foreach($customers as $customer)
                <tr>
                    <td><a href="{{ route('customer.account', ['customer' => $customer->id]) }}">{{ $customer['name'] }}</a></td>
                    <td>{{ sprintf("%.2f",  $customer['balance']) }}</td>
                    @for($i = 6; $i >= 0; $i--)
                        @php
                            $day = request('searchDate') ? \Carbon\Carbon::createFromFormat("Y-m-d",request('searchDate')) : \Carbon\Carbon::today();
                            $daySeach = $day->subDay($i)->format("Y-m-d");
                        @endphp
                        @if($customer->customerReports->where('date', $daySeach)->first())
                               <td style="color: #f8b600; font-weight: bold">{{ $customer->customerReports->where('date', $daySeach)->first()->spent }}</td>
                            @else<td>0</td>@endif
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

                    for (let i = 1; i < 10; i++) {
                        $("#total"+i).html(api
                            .column(i, {search: 'applied' })
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0).toFixed(2));
                    }

                },
                fixedColumns: {
                    start: 2,
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
        function showBalance() {
            document.getElementById("balanceModal").style.display = "block";
        }

        function hideBalance() {
            document.getElementById("balanceModal").style.display = "none";
        }

        function totalSpent() {
            document.getElementById("totalModal").style.display = "block";
        }
        function hideTotal() {
            document.getElementById("totalModal").style.display = "none";
        }

        let spentDay = document.getElementById("spentDay");
        let spentWeek = document.getElementById("spentWeek");
        let spentMonth = document.getElementById("spentMonth");

        function totalDay() {
            document.getElementById("totalSpend").innerHTML = "Total Spend Day";
            spentDay.style.display = "block";
            spentWeek.style.display = "none";
            spentMonth.style.display = "none";
            document.getElementById("totalModal").style.display = "none";
        }
        function totalWeek() {
            document.getElementById("totalSpend").innerHTML = "Total Spend Week";
            spentDay.style.display = "none";
            spentWeek.style.display = "block";
            spentMonth.style.display = "none";
            document.getElementById("totalModal").style.display = "none";
        }
        function totalMonth() {
            document.getElementById("totalSpend").innerHTML = "Total Spend Month";
            spentDay.style.display = "none";
            spentWeek.style.display = "none";
            spentMonth.style.display = "block";
            document.getElementById("totalModal").style.display = "none";
        }
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
        var labels = ["Total Spend", "Total Balance"];
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
                        text: "Total Spend / Total Balance"
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

