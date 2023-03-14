@extends('pages.admin.home')

@section('content')
    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="col-lg-10 bg-light shadow-sm p-3">
        <label for="adding new item">
            <h1>Edit Item Details</h1>
        </label>
        <form action="{{ route('update_item_details', $item->serial_number) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col">
                    <label for="location">Location:</label>
                    <select id="location" name="location" class="form-control col-sm-5">
                        <option value="{{ $item->location }}" selected>{{ $item->location }}</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->room_name }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>

                    @error('room')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Item name/description">Item Name/Description:</label>
                    <input type="text" id="item_description" name="item_description"
                        value="{{ $item->item_description }}"
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
                        placeholder="Aquistion Date" value="{{ $item->aquisition_date }}">

                    <label for="unit number">Unit Number:</label>
                    <input type="text" id="unit_number" name="unit_number"
                        class="form-control col-sm-4 @error('unit_number')
                    border-danger @enderror"
                        value="{{ $item->unit_number }}" placeholder="Unit Number">
                    <p class="text-sm font-italic" style="font:italic">Type N/A or None if no unit number.</p>
                    @error('unit_number')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

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

                </div>

                <div class="col">
                    <label for="serial number"> Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number"
                        class="form-control @error('serial_number')
                    border-danger @enderror"
                        value="{{ $item->serial_number }}" placeholder="Serial Number">
                    @error('serial_number')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="quantity">Quantity:</label>
                    <input type="text" id="quantity" name="quantity"
                        class="form-control col-sm-3 @error('quantity')
                    border-danger @enderror"
                        value="{{ $item->quantity }}" placeholder="Quantity">
                    @error('quantity')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="status">Status:</label>
                    <select name="status" id="status" name="status" class="form-control">
                        <option value="{{ $item->status }}">{{ $item->status }}</option>
                        <option value="Active">Active</option>
                        <option value="For Repair">For Repair</option>
                        <option value="Obsolete">Obsolete</option>
                    </select>

                    <label for="borrowed or not">Is it borrowed or not?</label>
                    @if ($item->borrowed == 'no')
                        <label for="" class="radio-inline">
                            <input type="radio" id='borrowed' name="borrowed" value="no" checked>
                            No
                        </label>
                        /
                        <label for="" class="radio-inline">
                            <input type="radio" id='borrowed' name="borrowed" value="yes">
                            Yes
                        </label>
                    @else
                        <label for="" class="radio-inline">
                            <input type="radio" id='borrowed' name="borrowed" value="no">
                            No
                        </label>
                        /
                        <label for="" class="radio-inline">
                            <input type="radio" id='borrowed' name="borrowed" value="yes" checked>
                            Yes
                        </label>
                    @endif

                    <hr>
                    <a href="{{ route('view_items') }}" class="btn btn-outline-dark">Cancel</a>
                    <Button type="submit" class="btn btn-success">Save</Button>
                </div>
            </div>
        </form>
    </div>
@endsection
