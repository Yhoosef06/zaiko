<form class="form-signin" action="{{route('save_new_model')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">Brand Name:</label>
    <select class="form-control @error('brand_id') border-danger @enderror" name="brand_id" id="brand_id" required>
        <option value="" disabled selected>Select a brand for the model</option> 
        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}" >{{$brand->brand_name}}</option>
        @endforeach
    </select>
    <label for="">Model Name:</label>
    <input type="text" name="model_name" id="model_name" placeholder="Enter a model name"
        class="form-control @error('model_name') border-danger @enderror" required>
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to add a new room name. Do you wish to continue?')">Save</Button>
</form>
