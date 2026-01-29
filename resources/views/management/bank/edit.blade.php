@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Add New Bank</h6>
                    <form action="{{route('management.bank.update', ['id' => $bank->id])}}" method="post">
                        @csrf
                        <input type="hidden" name="admin_id" value="{{ \Illuminate\Support\Facades\Auth::guard('admin')->id() }}">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="name" value="{{ $bank->name }}">
                            <label for="floatingInput">Name</label>
                            @if ($errors->has('name'))
                                <p style="color: #ff0000">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="owner" value="{{ $bank->owner }}">
                            <label for="floatingInput">Owner</label>
                            @if ($errors->has('owner'))
                                <p style="color: #ff0000">{{ $errors->first('owner') }}</p>
                            @endif
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="bank_account" value="{{ $bank->bank_account }}">
                            <label for="floatingInput">Bank Account</label>
                            @if ($errors->has('bank_account'))
                                <p style="color: #ff0000">{{ $errors->first('bank_account') }}</p>
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

