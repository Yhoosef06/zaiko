<form id="filterForm" method="GET" action="{{ route('get_filtered_items') }}">
    <div class="row">
        <div class="col-md-3">
            <label for="brandFilter">Brand:</label>
            <div>
                @foreach ($items->unique('brand.brand_name') as $item)
                    <input type="checkbox" name="brand_ids[]" value="{{ $item->brand_id }}"
                        @if (in_array($item->brand_id, old('brand_ids', []))) checked @endif>
                    {{ $item->brand->brand_name }}<br>
                @endforeach
            </div>
        </div>
        <div class="col-md-3">
            <label for="locationFilter">Model:</label>
            <div>
                @foreach ($items->unique('model.model_name') as $item)
                    <input type="checkbox" name="model_ids[]" value="{{ $item->model_id }}">
                    {{ $item->model->model_name }}<br>
                @endforeach
            </div>
        </div>
        <div class="col-md-3">
            <label for="categoryFilter">Category:</label>
            <div>
                @foreach ($items->unique('category.category_name') as $item)
                    <input type="checkbox" name="category_ids[]" value="{{ $item->category_id }}">
                    {{ $item->category->category_name }}<br>
                @endforeach
            </div>
        </div>
        <div class="col-md-3">
            <label for="locationFilter">Location:</label>
            <div>
                @foreach ($items->unique('room.room_name') as $item)
                    <input type="checkbox" name="room_ids[]" value="{{ $item->location }}">
                    {{ $item->room->room_name }}<br>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-olive" id="applyFilter">Apply</button>
    </div>
</form>
