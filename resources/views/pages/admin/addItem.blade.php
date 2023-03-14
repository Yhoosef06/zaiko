@extends('pages.admin.home')

@section('content')
    @if (session('status'))
        <div class="container alert text-center">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="col-lg-10 bg-light shadow-sm p-3">
        <label for="adding new item">
            <h1>Adding New Item</h1>
        </label>
        <form action="{{ route('save_new_item') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="location">Location:</label>
                    <select id="location" name="location" class="form-control col-sm-5 @error('location')
                        border-danger @enderror">
                        <option value="option_select" disabled selected>Select a location</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->room_name }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>

                    @error('location')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Item name/description">Item Name/Description:</label>
                    <input type="text" id="item_description" name="item_description"
                        value="{{ old('item_description') }}"
                        class="form-control @error('item_description')
                    border-danger
                    @enderror"
                        placeholder="Item Name/Description">
                    @error('item_description')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="aquisition date">Aquisition Date:</label>
                    <input type="date" id="aquisition_date" name="aquisition_date" class="form-control"
                        placeholder="Aquistion Date">

                    <label for="unit number">Unit Number:</label>
                    <input type="text" id="unit_number" name="unit_number"
                        class="form-control col-sm-4 @error('unit_number')
                    border-danger @enderror"
                        value="{{ old('unit_number') }}" placeholder="Unit Number">
                    @error('unit_number')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    <p class="text-sm font-italic" style="font:italic">Type N/A or None if no unit number.</p>

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
                </div>

                <div class="col">
                    <label for="serial number"> Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number"
                        class="form-control @error('serial_number')
                    border-danger @enderror"
                        value="{{ old('serial_number') }}" placeholder="Serial Number">
                    @error('serial_number')
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
                    <select name="status" id="status" name="status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="For Repair">For Repair</option>
                        <option value="Obsolete">Obsolete</option>
                    </select>

                    <label for="borrowed or not">Is it borrowed or not?</label>
                    <label for="" class="radio-inline">
                        <input type="radio" id='borrowed' name="borrowed" value="no" checked>
                        No
                    </label>
                    /
                    <label for="" class="radio-inline">
                        <input type="radio" id='borrowed' name="borrowed" value="yes">
                        Yes
                    </label>
                    <hr>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                    <Button type="submit" class="btn btn-success">Submit</Button>
                </div>
            </div>
        </form>
    </div>
@endsection
