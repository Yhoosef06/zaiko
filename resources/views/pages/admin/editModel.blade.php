<form class="form-signin" action="{{route('save_edited_model', ['id' => $model->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">Brand Name:</label>
    <select class="form-control @error('brand_id') border-danger @enderror" name="brand_id" id="brand_id" required>
        <option value="{{$model->brand_id}}">{{ $model->brand->brand_name }}</option> 
        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}" >{{$brand->brand_name}}</option>
        @endforeach
    </select>
    <label for="">Model Name:</label>
    <input type="text" name="model_name" id="model_name" placeholder="Enter a model name"
        class="form-control" value="{{$model->model_name}}">
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to add a new room name. Do you wish to continue?')">Save</Button>
</form>
