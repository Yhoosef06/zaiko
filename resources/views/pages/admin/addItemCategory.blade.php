<form class="form-signin" action="{{route('save_new_category')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">Item Category Name:</label>
    <input type="text" name="category_name" id="category_name" placeholder="Enter a item category name"
        class="form-control @error('category_name') border-danger @enderror" required>
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to add a new item category name. Do you wish to continue?')">Save</Button>
</form>
