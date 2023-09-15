@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- Adding distance from the top navigation bar --}}
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                                </div>
                            @elseif (session('danger'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                                </div>
                            @endif

                            <h3>Adding New Item</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('save_new_item') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <label for="location">Room/Location: </label>
                                        <div style="display:flex">
                                            <select id="location" name="location"
                                                class="form-control @error('location')
                                                            border-danger @enderror">
                                                <option value="option_select" disabled selected>Choose a room</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}"
                                                        {{ old('location') == $room->id ? 'selected' : '' }}>
                                                        {{ $room->room_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if (Auth::user()->account_type != 'admin')
                                                <a class="btn text-blue" href="#"><i class="fa fa-plus-circle"
                                                        data-toggle="modal" data-target="#addRoomModal"
                                                        data-toggle="tooltip" title='Add a room' data-toggle="modal"
                                                        {{-- data-target="#modal-addRoom" --}}></i></a>
                                            @endif
                                        </div>
                                        @error('location')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="Item name">Item Category:</label>
                                        <div style="display:flex">
                                            <select id="item_category" name="item_category"
                                                class="form-control @error('item_category')
                                            border-danger @enderror">
                                                <option value="option_select" disabled selected>Select a category
                                                </option>
                                                @foreach ($itemCategories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('item_category') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if (Auth::user()->account_type != 'admin')
                                                <a class="btn text-blue" href="#"><i class="fa fa-plus-circle"
                                                        data-toggle="modal" data-target="#addItemCategoryModal"
                                                        data-toggle="tooltip" title='Add a category'></i></a>
                                            @endif
                                        </div>
                                        @error('item_category')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="Item description">Description:</label>
                                        <input type="text" id="item_description" name="item_description"
                                            value="{{ old('item_description') }}"
                                            class="form-control @error('item_description')
                                        border-danger
                                        @enderror"
                                            placeholder="Enter an item description">
                                        @error('item_description')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="Brand">Brand:</label>
                                        <div style="display:flex">
                                            <select id="brand" name="brand"
                                                class="form-control @error('brand') border-danger @enderror">
                                                <option value="option_select" disabled selected>Select a brand. (Skip if
                                                    none)</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ old('brand') == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if (Auth::user()->account_type != 'admin')
                                                <a class="btn text-blue" href="#"><i class="fa fa-plus-circle"
                                                        data-toggle="modal" data-target="#addBrandModal"
                                                        data-toggle="tooltip" title='Add a brand'></i></a>
                                            @endif
                                        </div>

                                        <label for="Model">Model:</label>
                                        <div style="display:flex">
                                            <select id="model" name="model"
                                                class="form-control @error('model') border-danger @enderror">
                                                <option value="option_select" disabled selected>Select a model. (Skip if
                                                    none)</option>
                                                <!-- Models options will be populated dynamically here -->
                                            </select>
                                            @if (Auth::user()->account_type != 'admin')
                                                <a class="btn text-blue" href="#"><i class="fa fa-plus-circle"
                                                        data-toggle="modal" data-target="#addModelModal"
                                                        data-toggle="tooltip" title='Add a model'></i></a>
                                            @endif
                                        </div>

                                        <label for="Model">Part Number:</label>
                                        <input type="text" id="part_number" name="part_number"
                                            value="{{ old('part_number') }}"
                                            class="form-control  @error('part_number')
                                        border-danger
                                        @enderror"
                                            placeholder="Enter a part number. (Leave blank if none)">
                                        @error('part_number')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col">
                                        <label for="aquisition date">Aquisition Date:</label>
                                        <input type="date" id="aquisition_date" name="aquisition_date"
                                            class="form-control  @error('aquisition_date')
                                            border-danger
                                            @enderror"
                                            value="{{ old('aquisition_date') }}" placeholder="Aquistion Date">
                                        @error('aquisition_date')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="Item image">Upload Image:</label>
                                        <div style="display: flex">
                                            <input type="file" id="item_image" name="item_image"
                                                value="{{ old('item_image') }}"
                                                class="form-control @error('item_image')
                                        border-danger
                                        @enderror">
                                            {{-- <button class="btn btn-default">
                                                <i class="fa fa-camera"></i>
                                            </button> --}}
                                        </div>
                                        @error('item_image')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="duration">Set Borrowing Period:</label>
                                        <div class="row">
                                            <div class="col">
                                                <select id="duration_type" name="duration_type" class="form-control">
                                                    <option value="General" selected>General</option>
                                                    <option value="Specific">Specific</option>
                                                </select>
                                            </div>

                                            <div class="col">
                                                <div style="display: flex">
                                                    <input type="text" id="duration" name="duration" value="7"
                                                        class="form-control" style="width: 45px;" readonly>
                                                    <label for="" class="radio-inline pl-1">
                                                        day/s
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label for="status">Status:</label>
                                            </div>

                                            <div class="col">
                                                <label for="borrowed or not">Property Sticker:</label>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <select id="status" name="status" class="form-control">
                                                    <option value="Active">Active</option>
                                                    <option value="For Repair">For Repair</option>
                                                    <option value="Obsolete">Obsolete</option>
                                                    <option value="Lost">Lost</option>
                                                </select>
                                            </div>

                                            <div class="col">
                                                <div class="container">
                                                    <label for="" class="radio-inline">
                                                        <input type="radio" id='inventory_tag' name="inventory_tag"
                                                            value="with">
                                                        With
                                                    </label>
                                                    /
                                                    <label for="" class="radio-inline">
                                                        <input type="radio" id='inventory_tag' name="inventory_tag"
                                                            value="without" checked>
                                                        Without
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <label for="quantity">Quantity:</label>
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" id="quantity" name="quantity"
                                                    class="form-control @error('quantity') border-danger @enderror"
                                                    value="{{ old('quantity') }}" placeholder="Enter a quantity"
                                                    oninput="updateSerialNumberFields()">

                                                @error('quantity')
                                                    <div class="text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <br>
                                                <div id="serial_numbers_container"
                                                    style="max-height: 200px; overflow-y: auto;"
                                                    data-has-error="{{ $errors->has('serial_number') ? 'true' : 'false' }}">

                                                </div>
                                            </div>
                                            <div class="col">
                                                <strong>With serial number/s?</strong>
                                                <input type="checkbox" id="checkbox" name="checkbox" value="1"
                                                    @if ($errors->has('serial_number'))  @endif
                                                    onchange="updateSerialNumberFields();">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <hr>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                                <Button type="submit" class="btn btn-success" data-toggle="modal"
                                    data-target="#modal-submitConfirmation"
                                    onclick="return confirm('Please review all entries before proceeding. Do you wish to continue?')">Save</Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        </div>
    </section>
    {{-- FOR ADDING A ROOM --}}

    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Adding a Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    {{-- FOR ADDING AN ITEM CATEGORY --}}
    <div class="modal fade" id="addItemCategoryModal" tabindex="-1" aria-labelledby="addCollegeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCollegeModalLabel">Adding a Item Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal -->

    {{-- FOR ADDING A BRAND --}}
    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addCollegeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">Adding a Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="addModelModal" tabindex="-1" aria-labelledby="addCollegeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModelModalLabel">Adding a Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
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

<script type="text/javascript">
    $(document).ready(function() {
        // Listen for changes in the brand select dropdown
        $('#brand').change(function() {
            // Get the selected brand's ID
            var selectedBrandId = $(this).val();

            // Send an AJAX request to fetch models associated with the selected brand
            $.ajax({
                url: '/get-models/' + selectedBrandId, // Replace with the actual route
                type: 'GET',
                success: function(data) {
                    // Clear existing model options
                    $('#model').empty();

                    // Add the default option
                    $('#model').append(
                        '<option value="option_select" disabled selected>Select a model. (Skip if none)</option>'
                    );

                    // Populate the model select dropdown with new options
                    $.each(data, function(index, model) {
                        $('#model').append('<option value="' + model.id + '">' +
                            model.model_name + '</option>');
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        $('#addModelModal').on('show.bs.modal', function(event) {
            var modal = $(this);

            $.get("{{ route('add_model') }}", function(data) {
                modal.find('.modal-body').html(data);
            });
        });
    });

    $(document).ready(function() {
        $('#addRoomModal').on('show.bs.modal', function(event) {
            var modal = $(this);

            $.get("{{ route('add_room') }}", function(data) {
                modal.find('.modal-body').html(data);
            });
        });
    });


    $(document).ready(function() {
        $('#addItemCategoryModal').on('show.bs.modal', function(event) {
            var modal = $(this);

            $.get("{{ route('add_item_category') }}", function(data) {
                modal.find('.modal-body').html(data);
            });
        });
    });

    $(document).ready(function() {
        $('#addBrandModal').on('show.bs.modal', function(event) {
            var modal = $(this);

            $.get("{{ route('add_brand') }}", function(data) {
                modal.find('.modal-body').html(data);
            });
        });
    });

    $(document).ready(function() {
        $('#brand').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '{!! url('get-brand') !!}',
                    dataType: 'json',
                    data: {
                        query: request
                            .term
                    },
                    success: function(data) {
                        var filteredData = $.grep(data, function(item) {
                            return item.substr(0, request.term.length)
                                .toLowerCase() === request.term.toLowerCase();
                        });
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
                $.ajax({
                    url: '{!! url('get-model') !!}',
                    dataType: 'json',
                    data: {
                        query: request
                            .term
                    },
                    success: function(data) {
                        console.log(data);
                        var filteredData = $.grep(data, function(item) {
                            return item.substr(0, request.term.length)
                                .toLowerCase() === request.term.toLowerCase();
                        });
                        response(filteredData);
                    }
                });
            },
            minLength: 1,
            autoFocus: true,
        });
    });

    $(document).ready(function() {
        $('#part_number').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '{!! url('get-part-number') !!}',
                    dataType: 'json',
                    data: {
                        query: request
                            .term
                    },
                    success: function(data) {
                        console.log(data);
                        var filteredData = $.grep(data, function(item) {
                            return item.substr(0, request.term.length)
                                .toLowerCase() === request.term.toLowerCase();
                        });
                        response(filteredData);
                    }
                });
            },
            minLength: 1,
            autoFocus: true,
        });
    });

    $(document).ready(function() {
        // Use jQuery to attach the event listener
        $("#duration_type").on("change", function() {
            // Check the selected value
            if ($(this).val() === "Specific") {
                // If "Specific" is selected, make the input writable
                $("#duration").prop("readonly", false).val(""); // Clear the value
            } else {
                // If "General" is selected, make the input readonly and set the default value to 7
                $("#duration").prop("readonly", true).val("7");
            }
        });
    });


    function updateSerialNumberFields() {
        console.log('updateSerialNumberFields() called');
        const quantityField = document.getElementById('quantity');
        const container = document.getElementById('serial_numbers_container');
        const checkbox = document.getElementById('checkbox');
        const oldSerialNumberValue = @json(old('serial_number'));

        container.innerHTML = '';

        const quantity = parseInt(quantityField.value) || 0;
        const hasError = @json($errors->has('serial_number'));

        if (hasError || checkbox.checked) {
            for (let i = 1; i <= quantity; i++) {
                const label = document.createElement('label');
                label.for = `serial_number_${i}`;
                label.textContent = `Serial Number ${i}:`;

                const input = document.createElement('input');
                input.type = 'text';
                input.name = `serial_number[]`;
                input.id = `serial_number_${i}`;
                input.value = oldSerialNumberValue || '';
                input.classList.add('form-control', 'col-10');
                input.placeholder = 'Enter a serial number.';

                container.appendChild(label);
                container.appendChild(input);

                if (hasError) {
                    input.classList.add('border', 'border-danger');
                    const errorSpan = document.createElement('span');
                    errorSpan.classList.add('text-danger');
                    const errorMessage = document.createElement('p');
                    errorMessage.textContent = '{{ $errors->first('serial_number') }}';
                    errorSpan.appendChild(errorMessage);
                    container.appendChild(errorSpan);
                }
            }
        }
    }
</script>
