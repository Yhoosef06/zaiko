@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="alert alert-danger alert-dismissible">
            <i class="icon fas fa-exclamation-triangle"></i> {{ session('status') }}
        </div>
    @endif
    <div class="container col-lg-10 bg-light shadow-lg p-3">
        <label for="adding new item">
            <h2 class="text-decoration-underline">Adding New Item</h2>
        </label>
        <form action="{{ route('save_new_item') }}" method="POST">
            @csrf
            <div class="row m-2">
                <div class="col">
                    <label for="location">Room/Location: </label>
                    <div style="display:flex">
                        <div class=" form-group">
                            <select id="location" name="location"
                                class="form-control @error('location')
                                        border-danger @enderror">
                                <option value="option_select" disabled selected>Choose a room</option>
                                @foreach ($rooms as $room)
                                    @if (old('location') == $room->id)
                                        <option value="{{ old('location') }}" selected>{{ $room->room_name }}</option>
                                    @else
                                        <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('location')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <a class="btn text-blue" href="#"><i class="fa fa-plus-circle" data-toggle="modal"
                                    data-target="#modal-addRoom"></i></a>
                        </div>
                    </div>

                    <label for="Item name">Item Category:</label>
                    <div style="display:flex">
                        <div class="form-group">
                            <select id="item_category" name="item_category"
                                class="form-control @error('item_category')
                        border-danger @enderror">
                                <option value="option_select" disabled selected>Select a category</option>
                                @foreach ($itemCategories as $category)
                                    @if (old('item_category'))
                                        <option value="{{ old('item_category') }}" selected>{{ $category->category_name }}
                                        </option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->category_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            @error('item_category')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <a class="btn text-blue" href="#"><i class="fa fa-plus-circle" data-toggle="modal"
                                    data-target="#modal-addCategory"></i></a>
                        </div>
                    </div>

                    <label for="Brand">Brand:</label>
                    <div style="display:flex">
                        <div class="form-group">
                            <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                                class="form-control @error('brand')
                    border-danger
                    @enderror"
                                placeholder="Leave blank if none.">
                            @error('brand')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- <div>
                            <a class="btn text-blue" href="#"><i class="fa fa-plus-circle" data-toggle="modal"
                                    data-target="#modal-addBrand"></i></a>
                        </div> --}}
                    </div>

                    <div class="form-group">
                        <label for="Model">Model:</label>
                        <input type="text" id="model" name="model" value="{{ old('model') }}"
                            class="form-control col-5 @error('model')
                        border-danger
                        @enderror"
                            placeholder="Leave blank if none.">
                        @error('model')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="aquisition date">Aquisition Date:</label>
                        <input type="date" id="aquisition_date" name="aquisition_date" class="form-control col-sm-4"
                            placeholder="Aquistion Date">
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="Item description">Item Description:</label>
                        <input type="text" id="item_description" name="item_description"
                            value="{{ old('item_description') }}"
                            class="form-control @error('item_description')
                        border-danger
                        @enderror"
                            placeholder="Item Description">
                        @error('item_description')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="text" id="quantity" name="quantity"
                            class="form-control col-sm-3 @error('quantity') border-danger @enderror"
                            value="{{ old('quantity') }}" placeholder="Quantity" oninput="updateSerialNumberFields()">
                        <input type="checkbox" id="checkbox" name="checkbox" value="1"
                            onchange="this.value = this.checked ? '1' : '2'; updateSerialNumberFields(); console.log(this.value);"
                            checked>
                        <strong>Same serial numbers?</strong> <br>

                        @error('quantity')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" class="form-control col-sm-3">
                            <option value="Active">Active</option>
                            <option value="For Repair">For Repair</option>
                            <option value="Obsolete">Obsolete</option>
                            <option value="Lost">Lost</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="borrowed or not">Inventory Tag:</label>
                        <label for="" class="radio-inline">
                            <input type="radio" id='inventory_tag' name="inventory_tag" value="with">
                            With
                        </label>
                        /
                        <label for="" class="radio-inline">
                            <input type="radio" id='inventory_tag' name="inventory_tag" value="without" checked>
                            Without
                        </label>
                        <br>
                    </div>

                    <div class="form-group" id="serial_numbers_container"
                        data-error-message="{{ $errors->first('serial_numbers') }}">
                        @error('serial_numbers')
                            <span class="text-danger">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>

                    <hr>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                    <Button type="submit" class="btn btn-success" data-toggle="modal"
                        data-target="#modal-submitConfirmation"
                        onclick="return confirm('You are about to save a new item into your inventory. Do you wish to continue?')">Save</Button>
                </div>
            </div>
        </form>
    </div>

    {{-- FOR ADDING A ROOM --}}

    <div class="modal fade" id="modal-addRoom">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add a room</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add-room-form">
                    <div class="modal-body">
                        @csrf
                        @if (Auth::user()->account_type == 'admin')
                            <label for="department">Department:</label>
                            <select id="department_id" name="department_id"
                                class="form-control @error('department_id') border-danger @enderror">
                                <option value="" disabled selected>Select College Department</option>
                                @foreach ($departments->groupBy('college_name') as $collegeName => $departmentsGroup)
                                    <optgroup label="{{ $collegeName }}">
                                        @foreach ($departmentsGroup as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->department_name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <span id="department-error" class="text-danger"></span>
                        @endif
                        <label for="room_name">Room Name:</label>
                        <input type="text" name="room_name" id="room_name" class="form-control">
                        <span id="room-name-error" class="text-danger"></span>
                        <span id="room-name-success" class="text-success"></span>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="save-room-name" class="btn btn-primary"
                            onclick="return confirm('You are about to add a new room name. Do you wish to continue?')">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- FOR ADDING AN ITEM CATEGORY --}}
    <div class="modal fade" id="modal-addCategory">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add an item category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addCategoryForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="">Category Name:</label>
                        <input type="text" name="category_name" id="category_name" class="form-control"
                            placeholder="Category name">
                        <div id="category-name-error" class="text-danger"></div>
                        <div id="category-name-success" class="text-success"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('You are about to add a new category. Do you wish to continue?')">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- FOR ADDING A BRAND --}}
    <div class="modal fade" id="modal-addBrand">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add a brand name</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addBrandForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="">Brand Name:</label>
                        <input type="text" name="brand_name" id="brand_name" class="form-control"
                            placeholder="Brand name">
                        <span class="text-danger" id="brand-name-error"></span>
                        <span class="text-success" id="brand-name-success"></span>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('You are about to add new brand name. Do you wish to continue?')">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div id="success-message" style="display: none;">
        Data saved successfully.
    </div>
@endsection

<style>
    .ui-autocomplete {
        background-color: #ffffff;
        border: 1px solid #d2d6de;
        max-height: 200px;
        max-width: 400px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 9999;
        padding: 0;
        margin: 0;
    }

    .ui-menu-item {
        display: block;
        padding: 10px;
        clear: both;
        font-weight: normal;
        line-height: 1.42857143;
        color: #333333;
        white-space: nowrap;
    }

    .ui-menu-item:hover {
        background-color: #f4f4f4;
        color: #333333;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#brand').autocomplete({
            source: function(request, response) {
                // Send an AJAX request to the server to get the brand names
                $.ajax({
                    url: '{!! url('get-brand') !!}',
                    dataType: 'json',
                    data: {
                        query: request
                            .term // Pass the user's input as the 'query' parameter
                    },
                    success: function(data) {
                        // Filter the brand names to only include those that start with the user's input
                        var filteredData = $.grep(data, function(item) {
                            return item.substr(0, request.term.length)
                                .toLowerCase() === request.term.toLowerCase();
                        });
                        // Call the response callback with the filtered data
                        response(filteredData);
                    }
                });
            },
            minLength: 1,
            autoFocus: true,
        });
    });

    $(document).ready(function() {
        $('#model').autocomplete({
            source: function(request, response) {
                // Send an AJAX request to the server to get the brand names
                $.ajax({
                    url: '{!! url('get-model') !!}',
                    dataType: 'json',
                    data: {
                        query: request
                            .term // Pass the user's input as the 'query' parameter
                    },
                    success: function(data) {
                        console.log(data);
                        // Filter the brand names to only include those that start with the user's input
                        var filteredData = $.grep(data, function(item) {
                            return item.substr(0, request.term.length)
                                .toLowerCase() === request.term.toLowerCase();
                        });
                        // Call the response callback with the filtered data
                        response(filteredData);
                    }
                });
            },
            minLength: 1,
            autoFocus: true,
        });
    });

    $(document).ready(function() {
        $('#unit_number').autocomplete({
            source: function(request, response) {
                // Send an AJAX request to the server to get the brand names
                $.ajax({
                    url: '{!! url('get-unit-number') !!}',
                    dataType: 'json',
                    data: {
                        query: request
                            .term // Pass the user's input as the 'query' parameter
                    },
                    success: function(data) {
                        // Filter the brand names to only include those that start with the user's input
                        var filteredData = $.grep(data, function(item) {
                            return item.substr(0, request.term.length)
                                .toLowerCase() === request.term.toLowerCase();
                        });
                        // Call the response callback with the filtered data
                        response(filteredData);
                    }
                });
            },
            minLength: 1,
            autoFocus: true,
        });
    });

    // function updateSerialNumberFields() {
    //     const quantityField = document.getElementById('quantity');
    //     const container = document.getElementById('serial_numbers_container');
    //     const checkbox = document.getElementById('checkbox');

    //     // Check if there are existing input fields
    //     container.innerHTML = '';

    //     // Generate the new input field(s) and error messages
    //     const quantity = parseInt(quantityField.value) || 0;
    //     const errorMessage = container.dataset.errorMessage; // Retrieve the error message from the data attribute

    //     if (checkbox.checked) {
    //         // If checkbox is checked, generate one input field with a fixed label
    //         const label = document.createElement('label');
    //         label.for = `serial_number_1`;
    //         label.textContent = `Serial Number:`;

    //         const input = document.createElement('input');
    //         input.type = 'text';
    //         input.name = `serial_numbers[]`;
    //         input.id = `serial_number_1`;
    //         input.classList.add('form-control', 'col-sm-5');
    //         input.placeholder = 'Leave blank if none.';

    //         container.appendChild(label);
    //         container.appendChild(input);

    //         // Add error message element
    //         const errorSpan = document.createElement('p');
    //         errorSpan.classList.add('text-danger');
    //         errorSpan.textContent = errorMessage;
    //         container.appendChild(errorSpan);
    //     } else {
    //         // If checkbox is not checked, generate multiple input fields with numbered labels
    //         for (let i = 1; i <= quantity; i++) {
    //             const label = document.createElement('label');
    //             label.for = `serial_number_${i}`;
    //             label.textContent = `Serial Number ${i}:`;

    //             const input = document.createElement('input');
    //             input.type = 'text';
    //             input.name = `serial_numbers[]`;
    //             input.id = `serial_number_${i}`;
    //             input.classList.add('form-control', 'col-sm-5');
    //             input.placeholder = 'Leave blank if none.';

    //             container.appendChild(label);
    //             container.appendChild(input);

    //             // Add error message element
    //             const errorSpan = document.createElement('span');
    //             errorSpan.classList.add('text-danger');
    //             errorSpan.textContent = errorMessage;
    //             container.appendChild(errorSpan);
    //         }
    //     }
    // }

    function updateSerialNumberFields() {
        const quantityField = document.getElementById('quantity');
        const container = document.getElementById('serial_numbers_container');
        const checkbox = document.getElementById('checkbox');

        // Clear the existing error message
        const errorMessageElement = container.querySelector('.text-danger');
        if (errorMessageElement) {
            errorMessageElement.remove();
        }

        // Generate the new input field(s) and error messages
        const quantity = parseInt(quantityField.value) || 0;
        const errorMessage = container.dataset.errorMessage; // Retrieve the error message from the data attribute

        // Clear any existing input fields
        container.innerHTML = '';

        if (quantity > 0) {
            for (let i = 1; i <= quantity; i++) {
                const label = document.createElement('label');
                label.for = `serial_number_${i}`;
                label.textContent = `Serial Number ${i}:`;

                const input = document.createElement('input');
                input.type = 'text';
                input.name = `serial_numbers[]`;
                input.id = `serial_number_${i}`;
                input.classList.add('form-control', 'col-sm-5');
                input.placeholder = 'Leave blank if none.';

                container.appendChild(label);
                container.appendChild(input);
            }
        }

        // Add error message element if needed
        if (errorMessage && quantity === 0) {
            const errorSpan = document.createElement('span');
            errorSpan.classList.add('text-danger');
            errorSpan.textContent = errorMessage;
            container.appendChild(errorSpan);
        }
    }

    // FOR ADDING ROOM
    $(document).ready(function() {
        $('#add-room-form').on('submit', function(event) {
            event.preventDefault();
            var roomName = $('#room_name').val();
            var department = $('#department').val();

            $.ajax({
                url: "{{ route('store_new_room') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "room_name": roomName,
                    "department": department
                },
                success: function(response) {
                    roomId = response.id;
                    $('#room_name').removeClass('border border-danger');
                    $('#room-name-success').text(response.success);
                    $('#room_name').val('');
                    $('#department').val('');
                    $('#room-name-error').text('');

                    var currentRoomName = $('#brand').val();
                    var currentDepartment = $('#model').val();

                    location.reload();

                    var newOption = $('<option></option>').attr('value', roomId).text(
                        roomName);
                    $('#location').append(newOption);

                    // Restore the input values
                    $('#brand').val(currentRoomName);
                    $('#model').val(currentDepartment);

                    // Select the newly added option
                    // $('#location').val(roomName);
                },
                error: function(xhr) {
                    console.log(xhr);
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            if (errors.room_name) {
                                $('#room-name-error').text(errors.room_name[0]);
                                $('#room_name').addClass('border border-danger');
                            }
                            if (errors.department) {
                                $('#department-error').text(errors.department[0]);
                                $('#department').addClass('border border-danger');
                            }
                        }
                    } else {
                        if (xhr.responseJSON.error) {
                            $('#room-name-error').text('Room name has already been added.');
                            $('#room_name').addClass('border border-danger');
                            $('#room_name').val('');
                            $('#department').val('');
                            $('#room-name-success').text('');
                        }
                    }
                }
            });
        });
    });

    //for adding category
    $(document).ready(function() {
        $('#addCategoryForm').submit(function(event) {
            event.preventDefault();
            var category_name = $('#category_name').val();
            $.ajax({
                url: "{{ route('store_new_category') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "category_name": category_name,
                },
                success: function(response) {
                    $('#category-name-error').text('');
                    $('#category_name').removeClass('border border-danger');
                    $('#category-name-success').text(response.success);
                    $('#category_name').val('');

                    var newOption = $('<option></option>').attr('value', category_name)
                        .text(
                            category_name);
                    $('#item_category').append(newOption);

                    // Select the newly added option
                    $('#item_category').val(category_name);
                },
                error: function(xhr) {
                    console.log(xhr);
                    if (xhr.status === 422) {
                        $('#category-name-error').text(xhr.responseJSON.errors
                            .category_name[0]);
                        $('#category_name').addClass('border border-danger');
                    } else {
                        $('#category-name-error').text(
                            'Category name has already been added.');
                        $('#category_name').addClass('border border-danger');
                        $('#category-name-success').text('');
                    }
                }
            });
        });
    });

    //FOR ADDING BRAND NAME 
    $(document).ready(function() {
        $('#addBrandForm').submit(function(event) {
            event.preventDefault();
            var brand_name = $('#brand_name').val();
            $.ajax({
                url: "{{ route('store_new_brand') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "brand": brand_name,
                },
                success: function(response) {
                    $('#brand-name-error').text('');
                    $('#brand').removeClass('border border-danger');
                    $('#brand-name-success').text(response.success);
                    $('#brand_name').val('');
                },
                error: function(xhr) {
                    console.log(xhr);
                    if (xhr.status === 422) {
                        $('#brand-name-error').text(xhr.responseJSON.error);
                    } else {
                        $('#brand-name-error').text(
                            +data.brand_name + ' has already been added.');
                        $('#brand_name').addClass('border border-danger');
                        $('#brand-name-success').text('');
                    }
                }
            });
        });
    });
</script>
