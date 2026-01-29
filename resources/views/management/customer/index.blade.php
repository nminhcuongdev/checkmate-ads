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
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="col-3 col-xl-3">
            <div class="form-floating mb-3">
                <button class="btn btn-sm btn-primary" value="Export" onclick="showExport()">Export</button>
            </div>
        </div>

        <div class="modal fadeOut" tabindex="-1" role="dialog" id="exportModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Choose Month To Export!</h5>

                    </div>
                    <div class="modal-body">
                        <form action="{{ route('management.customer.export') }}" method="get">
                            <div class="row">
                                <div class="col-6 col-xl-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control"
                                               placeholder="Name" name="month" value="" >
                                        <label for="floatingInput">Date to Export</label>
                                    </div>
                                    <div class="col-3 col-xl-3">
                                        <div class="form-floating mb-3">
                                            <input type="submit" class="btn btn-sm btn-primary" value="Export">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="hideExport()" id="btnClose">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-light text-center rounded p-4">
            <table id="myTable" class="stripe row-border order-column" width="100%">
                @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">
                            <a href="{{ route('management.customer.create') }}"><i class="bi bi-plus-circle-fill"></i> Add</a>
                        </h6>
                    </div>
                @endif
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
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Code</th>
                        <th>Balance</th>
                        <th>Fee</th>
                        <th>Total Account</th>
                        <th>Tech</th>
                        <th>Account</th>
                        @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                            <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer['id'] }}</td>
                            <td>{{ $customer['name'] }}</td>
                            <td>{{ sprintf("%.2f",  $customer['balance']) }}</td>
                            <td>{{ $customer['fee'] }}%</td>
                            <td>@if(!empty($customer->accounts)) {{ $customer->accounts->count() }} @endif</td>
                            <td>@if(!empty($customer->admin)) {{ $customer->admin->name }} @endif</td>
                            <td>@if(!empty($customer->account)) {{ $customer->account->name }} @endif</td>
                            <td>
                                <div class="justify-content-around">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('management.customer.transfer', ['id' => $customer->id]) }}">Transfer</a>
                                    <a class="btn btn-sm btn-secondary" href="{{ route('management.customer.fixBalance', ['id' => $customer->id]) }}">Fix Balance</a>
                                    <a class="btn btn-sm btn-primary" href="{{ route('management.customer.edit', ['id' => $customer->id]) }}">Edit</a>
{{--                                    <button data-url="{{route('management.customer.delete', ['id'=>$customer->id])}}"--}}
{{--                                            onclick="showDeleteModal(this)" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-danger">Delete--}}
{{--                                    </button>--}}
                                    <script>
                                        function showDeleteModal(e){
                                            let url = $(e).data('url');
                                            $('#myModal').find('.btn-agree').attr('href', url);
                                        }
                                    </script>
                                </div>
                            </td>
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
        th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            width: 800px;
            margin: 0 auto;
        }
    </style>

    <script>
        function showExport() {
            document.getElementById("exportModal").style.display = "block";
        }

        function hideExport() {
            document.getElementById("exportModal").style.display = "none";
        }
    </script>
@endsection

