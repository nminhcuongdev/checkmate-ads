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
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Account</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $total }}
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
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Live</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $live }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa fa-heart text-lg opacity-10" aria-hidden="true"></i>
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
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Die</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $die  }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa fa-skull text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4 tbl-container">
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
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Currency</th>
                            @foreach($dates as $date)
                                <th>{{ $date->format('m/d') }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                        <tr class="text-dark">
                            <td colspan="3">Total</td>
                            @for($i = 3; $i <= count($dates)+3; $i++)
                                <td><b id="total{{$i}}"></b></td>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account['name'] }}</td>
                            <td>{{ $account['status'] }}</td>
                            <td>{{ $account['currency'] }}</td>
                            @php
                                $totalMonth = 0;
                            @endphp
                            @foreach($dates as $date)
                                @php
                                    $value = 0;
                                @endphp
                                @foreach($account['account_reports'] as $accountReport)
                                    @if($accountReport['date'] == $date->format('Y-m-d') && $accountReport['spent'] != 0)
                                        @php
                                            $value =  sprintf("%.2f", $accountReport['spent']);
                                            $totalMonth += $accountReport['spent'];
                                        @endphp
                                        @break
                                    @endif
                                @endforeach
                                @if($value != 0)
                                    <td style="color: #f8b600; font-weight: bold">{{ $value }}</td>
                                @else
                                    <td>{{ $value }}</td>
                                @endif

                            @endforeach
                            <td style="color: #f8b600; font-weight: bold" >{{ sprintf("%.2f", $totalMonth) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css">
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
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

                    for (let i = 3; i < {{ count($dates)+4 }}; i++) {
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
    <style>
        th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            width: 800px;
            margin: 0 auto;
        }
    </style>
@endsection

