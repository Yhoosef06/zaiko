@extends('layouts.pages.yields')

@section('content')

    @if (session('status'))
        <div class="container alert bg-gradient-lightblue text-center text-sm">
            <h4>{{ session('status') }}</h4>
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
                            <a class="btn text-blue" href="{{ route('adding_new_room') }}"><i
                                    class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>

                    @error('location')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Item name">Item Category:</label>
                    <select id="item_category" name="item_category"
                        class="form-control col-sm-8 @error('item_category')
                        border-danger @enderror">
                        <option value="option_select" disabled selected>Select a category</option>
                        @foreach ($itemCategories as $category)
                            <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @error('item_category')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Brand">Brand:</label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                        class="form-control @error('brand')
                    border-danger
                    @enderror"
                        placeholder="Brand Name (Leave an N/A if none.)">
                    @error('brand')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Model">Model:</label>
                    <input type="text" id="model" name="model" value="{{ old('model') }}"
                        class="form-control @error('model')
                    border-danger
                    @enderror"
                        placeholder="Model (Leave an N/A if none.)">
                    @error('model')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="aquisition date">Aquisition Date:</label>
                    <input type="date" id="aquisition_date" name="aquisition_date" class="form-control"
                        placeholder="Aquistion Date">

                    <label for="unit number">Unit Number:</label>
                    <input type="text" id="unit_number" name="unit_number"
                        class="form-control col-sm-5 @error('unit_number')
                    border-danger @enderror"
                        value="{{ old('unit_number') }}" placeholder="Unit Number     (Leave an N/A if none.)">
                    @error('unit_number')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col">

                    <label for="serial number"> Serial Number:</label>
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
                    <select id="status" name="status" class="form-control">
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
@endsection
