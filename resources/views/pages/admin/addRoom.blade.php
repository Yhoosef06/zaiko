<form class="form-signin" action="{{route('save_new_room')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="">Department Name:</label>
    <select class="form-control @error('department_id') border-danger @enderror" name="department_id" id="department_id" required>
        <option value="" disabled selected>Select a department where the room will belong to</option> 
        @foreach ($departments as $department)
            <option value="{{ $department->id }}" >{{$department->department_name}}</option>
        @endforeach
    </select>
    <label for="">Room Name:</label>
    <input type="text" name="room_name" id="room_name" placeholder="Enter a room name"
        class="form-control @error('room_name') border-danger @enderror" required>
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to add a new room name. Do you wish to continue?')">Save</Button>
</form>
