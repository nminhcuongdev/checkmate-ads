@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Add New Bank Report</h6>
                    <form action="{{route('management.bankreport.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="bank_id" value="{{ $bank->id }}">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" disabled
                                   placeholder="Name" value="{{ $bank->bank_account }}">
                            <label for="floatingInput">Bank Account</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date" name="date"/>
                            <label for="floatingInput">Date</label>
                        </div>
                        @if ($errors->has('date'))
                            <p style="color: #ff0000">{{ $errors->first('date') }}</p>
                        @endif
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="receive">
                            <label for="floatingInput">Receive</label>
                            @if ($errors->has('receive'))
                                <p style="color: #ff0000">{{ $errors->first('receive') }}</p>
                            @endif
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="transfer">
                            <label for="floatingInput">Transfer</label>
                            @if ($errors->has('transfer'))
                                <p style="color: #ff0000">{{ $errors->first('transfer') }}</p>
                            @endif
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="refund">
                            <label for="floatingInput">Refund</label>
                            @if ($errors->has('refund'))
                                <p style="color: #ff0000">{{ $errors->first('refund') }}</p>
                            @endif
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="pay">
                            <label for="floatingInput">Pay</label>
                            @if ($errors->has('pay'))
                                <p style="color: #ff0000">{{ $errors->first('pay') }}</p>
                            @endif
                        </div>
                        <div class="mb-4"></div>
                        <button class="btn btn-primary w-100 m-2" type="submit">Save</button>
                        <button class="btn btn-secondary w-100 m-2" type="button">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

