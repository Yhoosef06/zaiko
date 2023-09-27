<form class="form-signin" action="{{ route('save_edited_room', ['id' => $room->id]) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <label for="">Department Name:</label>
    @if (isset($departments))
        <select id="department_id" name="department_id"
            class="form-control @error('department_id') border-danger @enderror">
            <option value="" disabled selected>Select a Program/Department
            </option>
            @foreach ($departments->groupBy('college_name') as $collegeName => $departmentsGroup)
                <optgroup label="{{ $collegeName }}">
                    @foreach ($departmentsGroup as $department)
                        <option value="{{ $department->id }}"
                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    @endif
    <label for="">Room Name:</label>
    <input type="text" name="room_name" id="room_name" placeholder="Enter a room name" class="form-control"
        value="{{ $room->room_name }}">
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <Button type="submit" class="btn btn-success"
        onclick="return confirm('You are about to save changes. Do you wish to continue?')">Save</Button>
</form>
