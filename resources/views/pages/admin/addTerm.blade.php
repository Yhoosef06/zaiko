<form class="form-signin" action="{{route('save_new_term')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">Semester:</label>
    <select class="form-control" name="semester" id="semester">
        <option value="1st Semester">1st Semester</option>
        <option value="2nd Semester">2nd Semester</option>
        <option value="Summer">Summer</option>
    </select>

    <label for="">Start Date:</label>
    <input type="date" name="start_date" id="start_date"
        class="form-control @error('start_date') border-danger @enderror" required>

    <label for="">End Date:</label>
    <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') border-danger @enderror"
        required>
    <br>
    <label for="">isCurrent:</label>
    <input class="size-32" type="checkbox" name="isCurrent" id="isCurrent">

    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to add a new brand name. Do you wish to continue?')">Save</Button>
</form>

