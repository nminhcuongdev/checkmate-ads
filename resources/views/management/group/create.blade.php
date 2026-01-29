@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Add New Group</h6>
                    <form action="{{route('management.group.store')}}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Name" name="name">
                            <label for="floatingInput">Name</label>
                            @if ($errors->has('name'))
                                <p style="color: #ff0000">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="balanceGroup" value="1" id="balanceGroup">
                            <label class="form-check-label" for="balanceGroup">
                                Balance Group
                            </label>
                        </div>

                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="customer_id" id="mySelect">
                            <option value="">Choose customer</option>
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach

                        </select>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="shareGroup" value="1" id="shareGroup">
                            <label class="form-check-label" for="shareGroup">
                                Limit Share Group
                            </label>
                        </div>

                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="share_id" id="mySelect">
                            <option value="">Choose customer</option>
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
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
        $('#balanceGroup').change(function(e){
            $(this).siblings().prop('checked',false)
            var value = $(this).val();
            if(value == 'group') {
                $('#trip_members').prop('disabled', false);
            }else if(value == 'individual') {
                $('#trip_members').prop('disabled', true);
            }else if(value == '') {
                $('#trip_members').prop('disabled', false);
            }

        })


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

