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
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Notification</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $notifications->count() }}
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
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">
                    <a href="{{ route('management.notification.create') }}"><i class="bi bi-plus-circle-fill"></i> Add</a>
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                    <tr class="text-dark">
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $notification)
                    <tr>
                        <td>{{ $notification['id'] }}</td>
                        @php
                            $outContent = strlen($notification['content']) > 40 ? substr($notification['content'],0,40)."..." : $notification['content'];
                            $outTitle = strlen($notification['title']) > 40 ? substr($notification['title'],0,40)."..." : $notification['title'];
                        @endphp
                        <td>{{ $outTitle }}</td>
                        <td>{{ $outContent }}</td>
                        <td>{{ $notification['date'] }}</td>
                        <td>{{ config('const.notification.'. $notification['type']) }}</td>
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
                            @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                <a class="btn btn-sm btn-secondary" href="{{ route('management.notification.chooseCustomer', ['id' => $notification->id]) }}">Send</a>
                                <a class="btn btn-sm btn-primary" href="{{ route('management.notification.edit', ['id' => $notification->id]) }}">Edit</a>
                                <button data-url="{{route('management.history.delete', ['id'=>$notification->id])}}"
                                        onclick="showDeleteModal(this)" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-danger">Delete
                                </button>
                                <script>
                                    function showDeleteModal(e){
                                        let url = $(e).data('url');
                                        $('#myModal').find('.btn-agree').attr('href', url);
                                    }
                                </script>
                            @else
                                <a class="btn btn-sm btn-secondary" href="{{ route('customer.notification.show', ['id' => $notification->id]) }}">Show</a>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
{{--            <div class="d-flex align-items-center justify-content-center mt-4">--}}
{{--                {{ $histories->links() }}--}}
{{--            </div>--}}
        </div>
    </div>
@endsection

