<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zaiko.</title>
</head>

<body>
    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="container bg-light shadow-lg p-3">
        <form action="{{ route('update_item_details', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="location">Room/Location:</label>
                        <select id="location" name="location" class="form-control">
                            @foreach ($rooms as $room)
                                @if ($room->id == $item->location)
                                    <option value="{{ $room->id }}" selected>{{ $room->room_name }}</option>
                                @endif
                            @endforeach

                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Item name">Item Category:</label>
                        <select id="item_category" name="item_category"
                            class="form-control @error('item_category')
                border-danger @enderror">
                            <option value="{{ $item->item_category }}" disabled selected>{{ $item->item_category }}
                            </option>
                            @foreach ($itemCategories as $category)
                                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Brand">Brand:</label>
                        <input type="text" id="brand" name="brand" value="{{ $item->brand }}"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="Model">Model:</label>
                        <input type="text" id="model" name="model" value="{{ $item->model }}"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="aquisition date">Aquisition Date:</label>
                        <input type="date" id="aquisition_date" name="aquisition_date" class="form-control"
                            value="{{ $item->aquisition_date }}">
                    </div>

                    <div class="form-group">
                        <label for="unit number">Unit Number:</label>
                        <input type="text" id="unit_number" name="unit_number"
                            class="form-control @error('unit_number')
                                border-danger @enderror"
                            value="{{ $item->unit_number }}" placeholder="Unit Number">
                    </div>


                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="serial number"> Serial Number:</label>
                        <input type="text" id="serial_number" name="serial_number" class="form-control"
                            value="{{ $item->serial_number }}">
                    </div>

                    <div class="form-group">
                        <label for="Item Description">Item Description:</label>
                        <input type="text" id="description" name="description" value="{{ $item->description }}"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="text" id="quantity" name="quantity" class="form-control"
                            value="{{ $item->quantity }}">
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" name="status" class="form-control">
                            <option value="{{ $item->status }}">{{ $item->status }}</option>
                            <option value="Active">Active</option>
                            <option value="For Repair">For Repair</option>
                            <option value="Obsolete">Obsolete</option>
                        </select>
                    </div>

                    <div class="form-group">
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
                                <input type="radio" id='inventory_tag' name="inventory_tag" value="without"
                                    checked>
                                Without
                            </label>
                        @endif
                    </div>

                    <hr>
                    <a class="btn btn-outline-dark" data-dismiss="modal">Close</a>
                    <Button type="submit" class="btn btn-success"
                        onclick="return confirm('You are to save changes in the details of this item. Do you wish to continue?')">Save
                        Changes</Button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
