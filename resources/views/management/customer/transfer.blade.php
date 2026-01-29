@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <table class="table table-borderless">
            <tr>
                <td><b>Name:</b></td>
                <td>{{ $customer->name }}</td>
                <td></td>
                <td><b>Email:</b></td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td><b>Balance:</b></td>
                <td>{{ $customer->balance }}</td>
                <td></td>
                <td><b>Fee:</b></td>
                <td>{{ $customer->fee }}</td>
            </tr>
        </table>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Transfer Balance</h6>
                    <form action="{{route('management.customer.updateBalance', ['id' => $customer->id])}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $customer->id }}">

                        <div class="col-12 col-xl-12">
                            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="customer_id">
                                <option value="">Choose Customer</option>
                                @foreach($customers as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('admin_id'))
                                <p style="color: #ff0000">{{ $errors->first('admin_id') }}</p>
                            @endif
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Balance" name="" value="{{ $customer->balance }}" readonly>
                            <label for="floatingInput">Current Balance</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Amount Transfer" name="amount" value="">
                            <label for="floatingInput">Amount Transfer</label>
                        </div>
                        <button class="btn btn-primary w-100 m-2" type="submit">Transfer</button>
                        <a href="{{ route('management.customer') }}" class="btn btn-secondary w-100 m-2" type="button">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

