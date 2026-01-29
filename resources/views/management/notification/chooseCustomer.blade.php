@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Choose Customer</h6>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="checkAllCustomer">
                        <label class="form-check-label" for="checkAllCustomer">Select All Customers</label>
                    </div>
                    <form action="{{route('management.notification.send', ['id' => $notification->id])}}" method="post">
                        @csrf
                        @foreach($customers as $customer)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input selectCustomer" @if(in_array($customer->id, $notification->customerNotifications->pluck('customer_id')->toArray())) disabled @endif type="checkbox" id="customer_{{$loop->index}}" name="customer[{{ $loop->index }}][id]" value="{{ $customer->id }}" />
                                <label class="form-check-label"  for="customer_{{$loop->index}}">{{ $customer->name }}</label>
                            </div>
                        @endforeach
                        <button class="btn btn-primary w-100 m-2" type="submit">Send</button>
                        <button class="btn btn-secondary w-100 m-2" type="button">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const checkAllCustomer = document.getElementById("checkAllCustomer");
        const checkboxCustomers = document.getElementsByClassName("selectCustomer");

        checkAllCustomer.addEventListener("change", function() {
            if(checkAllCustomer.checked) {
                for (var i = 0; i < checkboxCustomers.length; ++i) { checkboxCustomers[i].checked = "checked"; }
            } else {
                for (var i = 0; i < checkboxCustomers.length; ++i) { checkboxCustomers[i].checked = false; }
            }
        });
    </script>
@endsection

