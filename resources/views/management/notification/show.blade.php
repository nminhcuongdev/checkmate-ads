@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Notification Detail</h6>
                        <p>Date: {{ $notification->date }}</p> <br>
                        <h1>{{ $notification->title }}</h1> <br> <br>
                        <p>{!! $notification->content !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

