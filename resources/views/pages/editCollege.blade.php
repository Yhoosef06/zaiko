<form class="form-signin" action="{{ route('save_edited_college', ['id' => $college->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">College Name:</label>
    <input type="text" name="college_name" id="college_name" placeholder="College Name" class="form-control"
        value="{{ $college->college_name }}">
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to save changes. Do you wish to continue?')">Save Changes</Button>
</form>
