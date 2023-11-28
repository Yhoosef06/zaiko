<form action="{{ route('update_item_details', $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
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
                            <option value="{{ $room->id }}" {{ $item->location == $room->id ? 'selected' : '' }}>
                                {{ $room->room_name }}
                            </option>
                        @endforeach
                    </select>
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
                                {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('item_category')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror

                <label for="Item description">Description:</label>
                <input type="text" id="description" name="description" value="{{ $item->description }}"
                    class="form-control @error('item_description')
                                        border-danger
                                        @enderror">

                <label for="Brand">Brand:</label>
                <div style="display:flex">
                    <select id="brand" name="brand" class="form-control @error('brand') border-danger @enderror">
                        <option value="option_select" disabled selected>Select a brand. (Skip if
                            none)</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $item->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->brand_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <label for="Model">Model:</label>
                <div style="display:flex">
                    <select id="model" name="model" class="form-control @error('model') border-danger @enderror">\
                        @foreach ($models as $model)
                            <option value="{{ $item->model_id }}"
                                {{ $item->model_id == $model->id ? 'selected' : '' }}>
                                {{ $model->model_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <label for="Model">Part Number:</label>
                <input type="text" id="part_number" name="part_number" value="{{ $item->part_number }}"
                    class="form-control  @error('part_number')
                                        border-danger
                                        @enderror">
            </div>

            <div class="col">
                <label for="Model">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" value="{{ $item->serial_number }}"
                    class="form-control">

                <label for="aquisition date">Aquisition Date:</label>
                <input type="date" id="aquisition_date" name="aquisition_date"
                    class="form-control  @error('aquisition_date')
                                            border-danger
                                            @enderror"
                    value="{{ $item->aquisition_date }}" placeholder="Aquistion Date">

                <label for="Item image">Upload Image:</label>
                <div style="display: flex">
                    <input type="file" id="item_image" name="item_image" value="{{ $item->item_image }}"
                        class="form-control @error('item_image')
                                        border-danger
                                        @enderror">
                    {{-- <button class="btn btn-default">
                                                <i class="fa fa-camera"></i>
                                            </button> --}}
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
                            <option value="Active" @if ($item->status === 'Active') selected @endif>Active
                            </option>
                            <option value="For Repair" @if ($item->status === 'For Repair') selected @endif>For
                                Repair
                            </option>
                            <option value="Obsolete" @if ($item->status === 'Obsolete') selected @endif>Obsolete
                            </option>
                        </select>
                    </div>

                    <div class="col">
                        <div class="container">
                            <label for="" class="radio-inline">
                                <input type="radio" id='inventory_tag' name="inventory_tag" value="with">
                                With
                            </label>
                            /
                            <label for="" class="radio-inline">
                                <input type="radio" id='inventory_tag' name="inventory_tag" value="without" checked>
                                Without
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="quantity">Quantity:</label>
                        <div style="display: flex">
                            <input type="text" id="quantity" name="quantity" style="max-width: 50px"
                                class="form-control @error('quantity') border-danger @enderror"
                                value="{{ $item->quantity }}" placeholder="Enter a quantity">
                        </div>
                    </div>
                    <div class="col">
                        <label for="duration">Set Penalty Fee (in PHP):</label>
                        <input type="number" id="penalty_fee" name="penalty_fee"
                            value="{{ $item->penalty_fee }}"
                            class="form-control @error('penalty_fee') border-danger @enderror" style="width: 100px;"
                            step="0.01" min="0.00" required>
                    </div>
                </div>

                <label for="duration">Set Borrowing Period For This Item:</label>
                <div class="row">
                    <div class="col">
                        <select id="duration_type" name="duration_type" class="form-control">
                            <option value="General" @if ($item->duration_type === 'General') selected @endif>Default</option>
                            <option value="Specific" @if ($item->duration_type === 'Specific') selected @endif>Custom</option>
                        </select>
                    </div>

                    <div class="col">
                        <div style="display: flex">
                            <input type="text" id="duration" name="duration" value="{{ $item->duration }}"
                                class="form-control" style="width: 45px;" readonly>
                            <label for="" class="radio-inline pl-1">
                                day/s
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div>
        <hr>
        <Button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</Button>
        <Button type="submit" class="btn btn-success"
            onclick="return confirm('Do you wish to continue updating this item?')">Save
            Changes</Button>
    </div>
</form>

{{-- @endsection --}}

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
        // Reference to the model select dropdown
        var modelSelect = $('#model');

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
                    modelSelect.empty();

                    // Add the static "N/A" option
                    modelSelect.append(
                        '<option value="1">Select a model. (Skip if none.)</option>');

                    // Populate the model select dropdown with new options
                    $.each(data, function(index, model) {
                        modelSelect.append('<option value="' + model.id + '">' +
                            model.model_name + '</option>');
                    });
                }
            });
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
        const quantityField = document.getElementById('quantity');
        const container = document.getElementById('serial_numbers_container');
        const checkbox = document.getElementById('checkbox');

        container.innerHTML = '';

        const quantity = parseInt(quantityField.value) || 0;
        const errorMessage = container.dataset.errorMessage;
        const hasError = container.dataset.hasError === 'true';
        if (checkbox.checked) {

            const label = document.createElement('label');
            label.for = `serial_number_1`;
            label.textContent = `Serial Number:`;

            const input = document.createElement('input');
            input.type = 'text';
            input.name = `serial_number`;
            input.id = `serial_number_1`;
            input.classList.add('form-control', 'col-10')
            input.placeholder = 'Enter a serial number. (Leave blank if none)';

            container.appendChild(label);
            container.appendChild(input);

            const errorSpan = document.createElement('p');
            errorSpan.classList.add('text-danger');
            errorSpan.textContent = errorMessage;
            container.appendChild(errorSpan);
        } else {
            for (let i = 1; i <= quantity; i++) {
                const label = document.createElement('label');
                label.for = `serial_number_${i}`;
                label.textContent = `Serial Number ${i}:`;

                const input = document.createElement('input');
                input.type = 'text';
                input.name = `serial_number[]`;
                input.id = `serial_number_${i}`;
                input.classList.add('form-control', 'col-10');
                input.placeholder = 'Enter a serial number.';

                container.appendChild(label);
                container.appendChild(input);

                const errorSpan = document.createElement('span');
                errorSpan.classList.add('text-danger');
                errorSpan.textContent = errorMessage;
                container.appendChild(errorSpan);
            }
        }
    }
</script>
