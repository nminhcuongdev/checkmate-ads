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
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Currency</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $currencies->count() }}
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
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <table id="myTable" class="stripe row-border order-column" width="100%">
            <thead>
            <tr>
                <th >Code</th>
                <th>Rate</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($currencies as $currency)
            <tr>
                <td>{{ $currency['code'] }}</td>
                <td>{{ $currency['rate'] }}</td>
                <td>
                    <div class="justify-content-around">
                        <a class="btn btn-sm btn-primary" href="{{ route('management.currency.edit', ['id' => $currency->id]) }}">Edit</a>
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
@endsection

