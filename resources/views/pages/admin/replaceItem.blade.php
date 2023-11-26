<form action="{{ route('save_replaced_item', ['id' => $item->id]) }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col">
                <label for="Brand">Brand:</label>
                <div style="display:flex">
                    <select id="brand" name="brand" class="form-control @error('brand') border-danger @enderror">
                        <option value="option_select" disabled selected>Select a brand. (Skip if
                            none)</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->brand_name }}
                            </option>
                        @endforeach
                    </select>
                    @if (Auth::user()->account_type != 'admin')
                        <a class="btn text-blue" href="#"><i class="fa fa-plus-circle" data-toggle="modal"
                                data-target="#addBrandModal" data-toggle="tooltip" title='Add a brand'></i></a>
                    @endif
                </div>

                <label for="Model">Model:</label>
                <div style="display:flex">
                    <select id="model" name="model" class="form-control @error('model') border-danger @enderror">
                        <option value="option_select" disabled selected>Select a model. (Skip if
                            none)</option>
                        <!-- Models options will be populated dynamically here -->
                    </select>
                    @if (Auth::user()->account_type != 'admin')
                        <a class="btn text-blue" href="#"><i class="fa fa-plus-circle" data-toggle="modal"
                                data-target="#addModelModal" data-toggle="tooltip" title='Add a model'></i></a>
                    @endif
                </div>

                <label for="Model">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number') }}"
                    class="form-control  @error('serial_number')
                                        border-danger
                                        @enderror"
                    placeholder="Enter a serial number. (Leave blank if none)">
                @error('serial_number')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col">
                <label for="Item description">Description:</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}"
                    class="form-control @error('description')
                                        border-danger
                                        @enderror"
                    placeholder="Enter an item description" required>
                @error('description')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror

                <label for="aquisition date">Aquisition Date:</label>
                <input type="date" id="aquisition_date" name="aquisition_date"
                    class="form-control  @error('aquisition_date')
                                            border-danger
                                            @enderror"
                    placeholder="Aquistion Date" required>
                @error('aquisition_date')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror

                <label for="Model">Part Number:</label>
                <input type="text" id="part_number" name="part_number" value="{{ old('part_number') }}"
                    class="form-control  @error('part_number')
                                        border-danger
                                        @enderror"
                    placeholder="Enter a part number. (Leave blank if none)">
                @error('part_number')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror

                {{-- <label for="borrowed or not">Property Sticker:</label> --}}
                <label for="" class="radio-inline">
                    <input type="radio" id='inventory_tag' name="inventory_tag" value="with" hidden>
                    {{-- With --}}
                </label>
                {{-- / --}}
                <label for="" class="radio-inline">
                    <input type="radio" id='inventory_tag' name="inventory_tag" value="without" checked hidden>
                    {{-- Without --}}
                </label>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <hr>
        <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
            Close
        </button>
        <Button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal-submitConfirmation"
            onclick="return confirm('Please review all entries before proceeding. Do you wish to continue?')">Save</Button>
    </div>
</form>

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
                <form class="form-signin" action="{{ route('save_new_brand') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <label for="">Brand Name:</label>
                    <input type="text" name="brand_name" id="brand_name" placeholder="Enter a brand name"
                        class="form-control @error('brand_name') border-danger @enderror" required>
                    <hr>
                    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                    <Button type="submit" class="btn btn-success"
                        onclick="return confirm('You are about to add a new brand name. Do you wish to continue?')">Save</Button>
                </form>

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
                <form class="form-signin" action="{{ route('save_new_model') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <label for="">Brand Name:</label>
                    <select class="form-control @error('brand_id') border-danger @enderror" name="brand_id"
                        id="brand_id" required>
                        <option value="" disabled selected>Select a brand for the model</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                        @endforeach
                    </select>
                    <label for="">Model Name:</label>
                    <input type="text" name="model_name" id="model_name" placeholder="Enter a model name"
                        class="form-control @error('model_name') border-danger @enderror" required>
                    <hr>
                    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                    <Button type="submit" class="btn btn-success"
                        onclick="return confirm('You are about to add a new room name. Do you wish to continue?')">Save</Button>
                </form>
            </div>
        </div>
    </div>
</div>

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
        $('#addModelModal').on('show.bs.modal', function(event) {
            var modal = $(this);

            $.get("{{ route('add_model') }}", function(data) {
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
                        '<option value="1" disabled selected>Select a model.</option>');

                    // Populate the model select dropdown with new options
                    $.each(data, function(index, model) {
                        modelSelect.append('<option value="' + model.id + '">' +
                            model.model_name + '</option>');
                    });
                }
            });
        });
    });
</script>
