@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="alert bg-danger text-m">
            <i class="fa fa-thumbs-down"></i> {{ session('status') }}
        </div>
    @endif

    <div class="col-lg-10 bg-light shadow-sm p-3">
        <label for="adding new item">
            <h2>Adding New Item</h2>
        </label>
        <form action="{{ route('save_new_item') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="location">Room/Location: </label>
                    <div style="display:flex">
                        <div>
                            <select id="location" name="location"
                                class="form-control @error('location')
                                        border-danger @enderror">
                                <option value="option_select" disabled selected>Choose a room</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <a class="btn text-blue" href="#"><i class="fa fa-plus-circle" data-toggle="modal"
                                    data-target="#modal-addRoom"></i></a>
                        </div>
                    </div>

                    @error('location')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Item name">Item Category:</label>
                    <div style="display:flex">

                        <select id="item_category" name="item_category"
                            class="form-control col-5 @error('item_category')
                        border-danger @enderror">
                            <option value="option_select" disabled selected>Select a category</option>
                            @foreach ($itemCategories as $category)
                                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>


                        <div>
                            <a class="btn text-blue" href="#"><i class="fa fa-plus-circle" data-toggle="modal"
                                    data-target="#modal-addCategory"></i></a>
                        </div>
                    </div>

                    @error('item_category')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Brand">Brand:</label>
                    <div style="display:flex">
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                            class="form-control col-sm-5 @error('brand')
                    border-danger
                    @enderror"
                            placeholder="Leave an N/A if none.">
                        @error('brand')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <div>
                            <a class="btn text-blue" href="#"><i class="fa fa-plus-circle" data-toggle="modal"
                                    data-target="#modal-addBrand"></i></a>
                        </div>
                    </div>

                    <label for="Model">Model:</label>
                    <input type="text" id="model" name="model" value="{{ old('model') }}"
                        class="form-control col-5 @error('model')
                    border-danger
                    @enderror"
                        placeholder="Leave an N/A if none.">
                    @error('model')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="aquisition date">Aquisition Date:</label>
                    <input type="date" id="aquisition_date" name="aquisition_date" class="form-control col-sm-4"
                        placeholder="Aquistion Date">

                    <label for="unit number">Unit Number:</label>
                    <input type="text" id="unit_number" name="unit_number"
                        class="form-control col-sm-5 @error('unit_number')
                    border-danger @enderror"
                        value="{{ old('unit_number') }}" placeholder="Leave an N/A if none.">
                    @error('unit_number')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col">

                    <label for="serial number"> Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number"
                        class="form-control col-sm-5 @error('serial_number')
                    border-danger @enderror"
                        value="{{ old('serial_number') }}" placeholder="Leave an N/A if none.">
                    @if (session()->has('message'))
                        <div class="text-danger">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @error('serial_number')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

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

                    <label for="quantity">Quantity:</label>
                    <input type="text" id="quantity" name="quantity"
                        class="form-control col-sm-3 @error('quantity')
                    border-danger @enderror"
                        value="{{ old('quantity') }}" placeholder="Quantity">
                    @error('quantity')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="status">Status:</label>
                    <select id="status" name="status" class="form-control col-sm-3">
                        <option value="Active">Active</option>
                        <option value="For Repair">For Repair</option>
                        <option value="Obsolete">Obsolete</option>
                        <option value="Lost">Lost</option>
                    </select>

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
                    {{-- <label for="serial number"> Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number"
                        class="form-control col-sm-4 @error('serial_number')
                    border-danger @enderror"
                        value="{{ old('serial_number') }}" placeholder="Serial Number">
                    @if (session()->has('message'))
                        <div class="text-danger">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @error('serial_number')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror --}}

                    <hr>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                    <Button type="submit" class="btn btn-success">Submit</Button>
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
                <form action="{{ route('store_new_room') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="">Room Name:</label>
                        <input type="text" name="room_name" id="room_name"
                            class="form-control password @error('room_name') border-danger @enderror"
                            placeholder="Room name">
                        @error('room_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @if (session('message'))
                            <div class="text-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
                <form action="{{ route('store_new_category') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="">Category Name:</label>
                        <input type="text" name="category_name" id="category_name"
                            class="form-control password @error('category_name') border-danger @enderror"
                            placeholder="Category name">
                        @error('category_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @if (session('message'))
                            <div class="text-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                <form action="{{ route('store_new_brand') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="">Brand Name:</label>
                        <input type="text" name="brand" id="brand"
                            class="form-control password @error('category_name') border-danger @enderror"
                            placeholder="Brand name">
                        @error('brand')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @if (session('message'))
                            <div class="text-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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
</script>
