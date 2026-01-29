@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            @if (Session::has('success'))
                <div class="alert alert-success" style="text-align: center;">
                    <strong>{{ session()->get('success') }}</strong>
                </div>
            @endif
            {{--            <div class="col-sm-6 col-xl-3">--}}
            {{--                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">--}}
            {{--                    <i class="ni ni-world fa-3x text-primary"></i>--}}
            {{--                    <div class="ms-3">--}}
            {{--                        <p class="mb-2">Total History</p>--}}
            {{--                        <h6 class="mb-0">{{ $histories->count() }}</h6>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="col-sm-6 col-xl-3">--}}
            {{--                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">--}}
            {{--                    <i class="ni ni-world fa-3x text-primary"></i>--}}
            {{--                    <div class="ms-3">--}}
            {{--                        <p class="mb-2">Total Amount</p>--}}
            {{--                        <h6 class="mb-0">{{ $histories->sum('amount') }}</h6>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Times</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $histories->count() }}
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Amount</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $histories->sum('amount') }}
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
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-left">Are you sure?</p>
                    </div>
                    <div class="modal-footer justify-between">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Cancel
                        </button>
                        <a href="" class="btn btn-danger btn-agree">OK</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-light text-center rounded p-4">
            <table id="myTable" class="stripe row-border order-column" width="100%">
                @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">
                            <a href="{{ route('management.history.create') }}"><i class="bi bi-plus-circle-fill"></i>
                                Add</a>
                        </h6>
                        <a href="">Export Excel</a>
                    </div>
                @endif
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Last Balance</th>
                    <th>Amount</th>
                    <th>Fee</th>
                    <th>Hash Code</th>
                    @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                        <th>Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($histories as $history)
                    <tr>
                        <td>{{ $history->id }}</td>
                        <td>@if($history->customer) {{ $history->customer->name }} @endif</td>
                        <td>{{ $history['date'] }}</td>
                        <td>{{ $history['last_balance'] }}</td>
                        <td>{{ $history['amount'] }}</td>
                        <td>{{ $history['fee'] }}</td>
                        <td>{{ (strlen($history['hashcode']) > 80) ? substr($history['hashcode'], 0, 80) . '...' : $history['hashcode'] }}</td>
                        @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                            <td>
                                <script>
                                    function showDeleteModal(e) {
                                        let url = $(e).data('url');
                                        $('#myModal').find('.btn-agree').attr('href', url);
                                    }
                                </script>

                                <button data-url="{{route('management.history.delete', ['id'=>$history->id])}}"
                                        onclick="showDeleteModal(this)" data-toggle="modal" data-target="#myModal"
                                        class="btn btn-sm btn-danger">Delete
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
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
        $(document).ready(function () {
            new DataTable('#myTable', {
                fixedHeader: true,
                scrollCollapse: true,
                scrollX: true,
                scrollY: 450,
                order: [[0, 'desc']],
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
        th, td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            width: 800px;
            margin: 0 auto;
        }
    </style>
@endsection

