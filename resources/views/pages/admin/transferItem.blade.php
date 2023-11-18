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
                        <label for="">Part Number:</label>
                        {{ $item->part_number === null ? 'N/A' : $item->part_number }}
                    </div>
                    <div>
                        <label for="">Serial Number:</label>
                        {{ $item->serial_number === null ? 'N/A' : $item->serial_number }}
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
            <form class="form-signin" action="{{ route('save_transfer_item', ['id' => $item->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <label for="">From:</label>
                <input type="text" class="form-control" name="room_from" id="room_from"
                    value="{{ $item->room->room_name }}" readonly>

                <label for="">To:</label>
                <select id="room_to" name="room_to" class="form-control @error('room_to') border-danger @enderror"
                    required>
                    <option value="" selected>Select a room</option>
                    @foreach ($rooms as $room)
                        @if ($room->id != $item->room->id)
                            <option value="{{ $room->id }}" {{ old('location') == $room->id ? 'selected' : '' }}>
                                {{ $room->room_name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @if ($item->quantity !== null && $item->quantity !== 1)
                    <label for="">Quantity:</label>
                    <input type="number" min="1" max="{{ $item->quantity }}" id="quantity" name="quantity"
                        class="form-control @error('quantity') border-danger @enderror" value="{{ old('quantity') }}"
                        @if (session('invalidSerialNumbers')) value="{{ old('quantity') }}" @endif
                        placeholder="Enter quantity to move" required>
                @endif
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
