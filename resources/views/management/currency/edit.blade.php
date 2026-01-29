@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Edit Customer</h6>
                    <form action="{{route('management.currency.update', ['id' => $currency->id])}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $currency->id }}">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" value="{{ $currency->code }}" readonly>
                            <label for="floatingInput">Name</label>
                            @if ($errors->has('code'))
                                <p style="color: #ff0000">{{ $errors->first('code') }}</p>
                            @endif
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Balcne" name="rate" value="{{ $currency->rate }}" >
                            <label for="floatingInput">Rate</label>
                            @if ($errors->has('rate'))
                                <p style="color: #ff0000">{{ $errors->first('rate') }}</p>
                            @endif
                        </div>
                        <button class="btn btn-primary w-100 m-2" type="submit">Save</button>
                        <button class="btn btn-secondary w-100 m-2" type="button">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

