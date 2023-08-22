<form class="form-signin" action="{{route('save_edited_department', ['id' => $department->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">College Name:</label>
    <select class="form-control @error('college_id') border-danger @enderror" name="college_id" id="college_id" required>
        <option value="{{$department->college_id}}">{{$department->college->college_name}}</option> 
        @foreach ($colleges as $college)
            <option value="{{ $college->id }}" >{{$college->college_name}}</option>
        @endforeach
    </select>
    <label for="">Department/Program Name:</label>
    <input type="text" name="department_name" id="department_name" placeholder="Enter a department/program name"
        class="form-control" value="{{$department->department_name}}">
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to save changes. Do you wish to continue?')">Save Changes</Button>
</form>
