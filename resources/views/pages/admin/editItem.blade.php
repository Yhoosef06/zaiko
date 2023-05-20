@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="container col-lg-10 bg-light shadow-sm p-3">
        <label for="adding new item">
            <h2>Edit Item Details</h2>
        </label>
        <form action="{{ route('update_item_details', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col">
                    <label for="location">Room/Location:</label>
                    <select id="location" name="location" class="form-control col-sm-5">
                        @foreach ($rooms as $room)
                            @if ($room->id == $item->location)
                                <option value="{{ $room->id }}" selected>{{ $room->room_name }}</option>
                            @endif
                        @endforeach

                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>

                    <label for="Item name">Item Category:</label>
                    <select id="item_category" name="item_category"
                        class="form-control col-5 @error('item_category')
                border-danger @enderror">
                        <option value="{{ $item->item_category }}" disabled selected>{{ $item->item_category }}</option>
                        @foreach ($itemCategories as $category)
                            <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>

                    <label for="Brand">Brand:</label>
                    <input type="text" id="brand" name="brand" value="{{ $item->brand }}"
                        class="form-control col-sm-5 ">

                    <label for="Model">Model:</label>
                    <input type="text" id="model" name="model" value="{{ $item->model }}"
                        class="form-control col-5">

                    <label for="aquisition date">Aquisition Date:</label>
                    <input type="date" id="aquisition_date" name="aquisition_date" class="form-control col-sm-4"
                        value="{{ $item->aquisition_date }}">

                    <label for="unit number">Unit Number:</label>
                    <input type="text" id="unit_number" name="unit_number"
                        class="form-control col-sm-4 @error('unit_number')
                    border-danger @enderror"
                        value="{{ $item->unit_number }}" placeholder="Unit Number">
                </div>

                <div class="col">
                    <label for="serial number"> Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number" class="form-control"
                        value="{{ $item->serial_number }}" p>

                    <label for="Item Description">Item Description:</label>
                    <input type="text" id="description" name="description"
                        value="{{ $item->description }}" class="form-control">

                    <label for="quantity">Quantity:</label>
                    <input type="text" id="quantity" name="quantity" class="form-control col-sm-3"
                        value="{{ $item->quantity }}">

                    <label for="status">Status:</label>
                    <select name="status" id="status" name="status" class="form-control">
                        <option value="{{ $item->status }}">{{ $item->status }}</option>
                        <option value="Active">Active</option>
                        <option value="For Repair">For Repair</option>
                        <option value="Obsolete">Obsolete</option>
                    </select>

                    <label for="borrowed or not">Inventory Tag:</label>
                    @if ($item->inventory_tag == 'with')
                        <label for="" class="radio-inline">
                            <input type="radio" id='inventory_tag' name="inventory_tag" value="with" checked>
                            With
                        </label>
                        /
                        <label for="" class="radio-inline">
                            <input type="radio" id='inventory_tag' name="inventory_tag" value="without">
                            Without
                        </label>
                    @else
                        <label for="" class="radio-inline">
                            <input type="radio" id='inventory_tag' name="inventory_tag" value="with">
                            With
                        </label>
                        /
                        <label for="" class="radio-inline">
                            <input type="radio" id='inventory_tag' name="inventory_tag" value="without" checked>
                            Without
                        </label>
                    @endif

                    <hr>
                    <a href="{{ route('view_items') }}" class="btn btn-outline-dark" data-dismiss="modal">Back</a>
                    <Button type="submit" class="btn btn-success" onclick="return confirm('Do you wish to continue updating this item?')">Save Changes</Button>
                </div>
            </div>
        </form>
    </div>
@endsection
