@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Edit Notification</h6>
                    <form action="{{route('management.notification.update', ['id' => $notification->id])}}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control"
                                   placeholder="date" name="date" value="{{ $notification->date }}">
                            <label for="floatingInput">Date</label>
                            @if ($errors->has('date'))
                                <p style="color: #ff0000">{{ $errors->first('date') }}</p>
                            @endif
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Amount" name="title" id="floatingInput" value="{{ $notification->title }}">
                            <label for="floatingInput">Title</label>
                            @if ($errors->has('title'))
                                <p style="color: #ff0000">{{ $errors->first('title') }}</p>
                            @endif
                        </div>
                        <div class="form-floating mb-3">

                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" style="height: 100%" name="content">{!! $notification->content !!}</textarea>
                            <label for="floatingInput">Content</label>
                            @if ($errors->has('content'))
                                <p style="color: #ff0000">{{ $errors->first('content') }}</p>
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

