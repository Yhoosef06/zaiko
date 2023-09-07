<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="text-center card-title font-weight-bold">Item Details</div>
                <div class=" card-body">
                    <div>
                        <label for="">Item ID #:</label> {{ $item->id }}
                    </div>
                    <div>
                        <label for="">Category:</label> {{ $item->category->category_name }}
                    </div>
                    <div>
                        <label for="">Brand:</label> {{ $item->brand->brand_name }}
                    </div>
                    <div>
                        <label for="">Model:</label> {{ $item->model->model_name }}
                    </div>
                    <div>
                        <label for="">Part Number:</label> {{ $item->model->part_number }}
                    </div>
                    <div>
                        <label for="">Serial Number:</label> {{ $item->model->serial_number }}
                    </div>
                    <div>
                        <label for="">Aquisition Date:</label> {{ $item->aquisition_date }}
                    </div>
                    <div>
                        <label for="">Quantity:</label> {{ $item->quantity }}
                    </div>
                    <div>
                        <label for="">Description:</label> {{ $item->description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <form class="form-signin" action="{{route('save_transfer_item', ['id' => $item->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">From:</label>
                <input type="text" class="form-control" name="room_from" id="room_from"
                    value="{{ $item->room->room_name }}" readonly>
                <label for="">To:</label>
                <select id="room_to" name="room_to"
                    class="form-control @error('location')
                                                            border-danger @enderror">
                    <option value="option_select" disabled selected>Choose a room</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('location') == $room->id ? 'selected' : '' }}>
                            {{ $room->room_name }}
                        </option>
                    @endforeach
                </select>
                <hr>
                <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
                    Close
                </button>
                <Button type="submit" class="btn btn-success"
                    onclick="return confirm('You are about to transfer a item. Do you wish to continue?')">Proceed</Button>
            </form>
        </div>
    </div>
</div>
</div>
