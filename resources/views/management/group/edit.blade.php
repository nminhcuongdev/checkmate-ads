@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Edit Customer</h6>
                    <form action="{{route('management.group.update', ['id' => $group->id])}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $group->id }}">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="name" value="{{ $group->name }}">
                            <label for="floatingInput">Name</label>
                            @if ($errors->has('name'))
                                <p style="color: #ff0000">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

                        <div class="form-check">
                            <input @if(!empty($group->customer_id)) checked @endif class="form-check-input" type="checkbox" name="balanceGroup" value="1" id="balanceGroup">
                            <label class="form-check-label" for="flexCheckDefault">
                                Balance Group
                            </label>
                        </div>

                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="customer_id" id="mySelect">
                            <option value="">Choose customer</option>
                            @foreach($customers as $customer)
                                <option {{ $group->customer_id == $customer->id ? "selected" : ""}}  value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>

                        <div class="form-check">
                            <input @if(!empty($group->share_id)) checked @endif class="form-check-input" type="checkbox" name="shareGroup" value="1" id="balanceGroup">
                            <label class="form-check-label" for="shareGroup">
                                Limit Share Group
                            </label>
                        </div>

                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="share_id" id="mySelect">
                            <option value="">Choose customer</option>
                            @foreach($customers as $customer)
                                <option {{ $group->share_id == $customer->id ? "selected" : ""}}  value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach

                        </select>
                        <button class="btn btn-primary w-100 m-2" type="submit">Save</button>
                        <button class="btn btn-secondary w-100 m-2" type="button">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let searchVal = '';
            $('#mySelect').on('keydown', function(e) {
                // Capture the character pressed
                const key = e.key;

                // Only allow single character input (a-z, A-Z)
                if (key.length === 1 && /^[a-zA-Z]$/.test(key)) {
                    searchVal += key.toLowerCase(); // Append the character to the search value

                    // Filter options based on the current search value
                    $('#mySelect option').each(function() {
                        const optionText = $(this).text().toLowerCase();
                        if (optionText.startsWith(searchVal)) {
                            $(this).show(); // Show if it matches
                        } else {
                            $(this).hide(); // Hide if it doesn't match
                        }
                    });
                } else if (key === "Backspace") {
                    // Handle backspace to remove last character
                    searchVal = searchVal.slice(0, -1);
                }
            });

            // Reset search when the dropdown loses focus
            $('#mySelect').on('blur', function() {
                searchVal = ''; // Clear search value
                $('#mySelect option').show(); // Show all options
            });
        });



    </script>
@endsection

