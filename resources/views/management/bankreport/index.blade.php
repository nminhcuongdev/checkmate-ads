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
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Reports</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $bankReports->count() }}
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
        <form action="" method="get">
            <div class="row">
                <div class="col-3 col-xl-3">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="bank_id">
                        <option value="">Choose Bank</option>
                        @foreach($banks as $bank)
                            <option {{getDataCreateForm('bank_data', 'bank_id') == $bank->id ? "selected" : ""}} value="{{$bank->id}}">{{$bank->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 col-xl-3">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control"
                               placeholder="Name" name="date" value="{{ request()->get('date') }}" >
                        <label for="floatingInput">Date</label>
                    </div>
                </div>
                <div class="col-3 col-xl-3">
                    <div class="form-floating mb-3">
                        <input type="submit" class="btn btn-sm btn-primary" value="Search">
                        <a href="{{ route('management.bankReport') }}" type="submit" class="btn btn-sm btn-primary">Clear</a>
                    </div>
                </div>
            </div>
        </form>
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 2)
                    <thead>
                    <tr class="text-dark">
                        <th scope="col">Bank</th>
                        <th scope="col">Receive</th>
                        <th scope="col">Transfer</th>
                        <th scope="col">Refund</th>
                        <th scope="col">Pay</th>
                        <th scope="col">Pay ( USD )</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><b>Total</b></td>
                        <td><b>{{ number_format($bankReports->sum('receive'), 0) }}</b></td>
                        <td><b>{{ number_format($bankReports->sum('transfer'), 0) }}</b></td>
                        <td><b>{{ number_format($bankReports->sum('refund'), 0) }}</b></td>
                        <td><b>{{ number_format($bankReports->sum('pay'), 0) }}</b></td>
                        <td><b>{{ number_format($bankReports->sum('pay_usd'), 2) }}</b></td>
                        <td><b>{{ number_format($bankReports->sum('balance'), 0) }}</b></td>
                        <td></td>
                    </tr>
                    @foreach($bankReports as $bankReport)
                    <tr>
                        <td>{{ $bankReport->bank->name . ' - ' . $bankReport->bank->bank_account }}</td>
                        <td>{{ number_format($bankReport['receive'], 0) }}</td>
                        <td>{{ number_format($bankReport['transfer'], 0) }}</td>
                        <td>{{ number_format($bankReport['refund'], 0) }}</td>
                        <td>{{ number_format($bankReport['pay'], 0) }}</td>
                        <td>{{ number_format($bankReport['pay_usd'], 2) }}</td>
                        <td>{{ number_format($bankReport['balance'], 0) }}</td>
                        <td>{{ $bankReport['date'] }}</td>
                        <td>
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
                            <div class="justify-content-around">
                                <button data-url="{{ route('management.bank.delete', ['id' => $bankReport['id']]) }}"
                                        onclick="showDeleteModal(this)" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-danger">Delete
                                </button>
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
                    @else
                        <thead>
                        <tr class="text-dark">
                            <th scope="col">Tech</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Receive</th>
                            <th scope="col">Transfer</th>
                            <th scope="col">Refund</th>
                            <th scope="col">Pay</th>
                            <th scope="col">Pay ( USD )</th>

                        </tr>
                        </thead>
                        <tbody>
{{--                        <tr>--}}
{{--                            <td><b>Total</b></td>--}}
{{--                            <td><b>{{ number_format($bankReports->sum('receive'), 0) }}</b></td>--}}
{{--                            <td><b>{{ number_format($bankReports->sum('transfer'), 0) }}</b></td>--}}
{{--                            <td><b>{{ number_format($bankReports->sum('refund'), 0) }}</b></td>--}}
{{--                            <td><b>{{ number_format($bankReports->sum('pay'), 0) }}</b></td>--}}
{{--                            <td><b>{{ number_format($bankReports->sum('pay_usd'), 2) }}</b></td>--}}
{{--                            <td><b>{{ number_format($bankReports->sum('balance'), 0) }}</b></td>--}}
{{--                            <td></td>--}}
{{--                        </tr>--}}
                        @foreach($techs as $tech)
                            <tr>
                                <td>{{ $tech->name }}</td>
                                @php
                                    $date = !empty(request('date')) ? request('date') : \Carbon\Carbon::today();
                                    $totalReceive = 0;
                                    $totalTransfer = 0;
                                    $totalRefund = 0;
                                    $totalPay = 0;
                                    $totalPayUSD = 0;
                                    $totalReceive = 0;
                                    $totalBalance = 0;
                                    foreach ($tech->banks as $bank) {
                                        $bankReports = \App\Models\BankReport::where('id', $bank->id)->where('date', $date);
                                        $totalReceive += $bankReports->sum('receive');
                                        $totalTransfer += $bankReports->sum('transfer');
                                        $totalRefund += $bankReports->sum('refund');
                                        $totalPay += $bankReports->sum('pay');
                                        $totalPayUSD += $bankReports->sum('pay_usd');
                                        $totalBalance += $bankReports->sum('balance');
                                    }
                                 @endphp
                                <td>{{ number_format($totalBalance, 0) . " ( " . $totalReceive . " + " . $totalRefund . " - " . $totalTransfer . " - " . $totalPay . " )"}}</td>
                                <td>{{ number_format($totalReceive, 0) }}</td>
                                <td>{{ number_format($totalTransfer, 0) }}</td>
                                <td>{{ number_format($totalRefund,0 ) }}</td>
                                <td>{{ number_format($totalPay, 0)  }}</td>
                                <td>{{ number_format($totalPayUSD, 2)  }}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>

            </div>
        </div>
    </div>
@endsection

