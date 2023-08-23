<form class="form-signin" action="{{ route('save_new_brand')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">Brand Name:</label>
    <input type="text" name="brand_name" id="brand_name" placeholder="Enter a brand name"
        class="form-control @error('brand_name') border-danger @enderror" required>
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to add a new brand name. Do you wish to continue?')">Save</Button>
</form>
