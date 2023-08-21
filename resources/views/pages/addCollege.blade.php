<form class="form-signin" action="{{ route('save_new_college') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">College Name:</label>
    <input type="text" name="college_name" id="college_name" placeholder="Enter a college name"
        class="form-control @error('college_name') border-danger @enderror" required>
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to add a new college name. Do you wish to continue?')">Save</Button>
</form>
