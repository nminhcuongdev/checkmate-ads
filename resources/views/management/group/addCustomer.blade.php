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
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Group Name</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $group->name }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
{{--                <h6 class="mb-0">--}}
{{--                    <a href="{{ route('management.group.create') }}"><i class="bi bi-plus-circle-fill"></i> Add</a>--}}
{{--                </h6>--}}
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                    <tr class="text-dark">
                        <th scope="col">STT</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td>{{ $customer['name'] }}</td>
                        <td>{{ $customer['email'] }}</td>
                        <td>
                            <div class="justify-content-around">
                                <a class="btn btn-sm btn-primary" href="{{ route('management.group.saveToGroup', ['id' => $group->id, 'customerId' => $customer->id]) }}">Add</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                <div class="d-flex align-items-center justify-content-center mt-4">--}}
{{--                    {{ $accounts->links() }}--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

