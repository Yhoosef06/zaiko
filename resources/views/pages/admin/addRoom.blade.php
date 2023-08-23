<form class="form-signin" action="{{ route('save_new_room') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="college_id">College Name:</label>
    <select class="form-control @error('college_id') border-danger @enderror" name="college_id" id="college_id" required>
        <option value="" disabled selected>College owner</option>
        @foreach ($colleges as $college)
            <option value="{{ $college->id }}">{{ $college->college_name }}</option>
        @endforeach
    </select>

    <label for="department_id">Department Name:</label>
    <select class="form-control @error('department_id') border-danger @enderror" name="department_id" id="department_id"
        required>
        <option value="" disabled selected>Department owner</option>
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

<script>
    // Listen for changes in the college dropdown
    document.getElementById('college_id').addEventListener('change', function() {
        var collegeId = this.value; // Get the selected college ID

        // Make an AJAX request to fetch departments based on the selected college
        fetch('/get-departments/' + collegeId)
            .then(response => response.json())
            .then(data => {
                // Update the department dropdown options
                var departmentDropdown = document.getElementById('department_id');
                departmentDropdown.innerHTML = ''; // Clear existing options

                // Add new options based on fetched data
                data.forEach(department => {
                    var option = document.createElement('option');
                    option.value = department.id;
                    option.textContent = department.department_name;
                    departmentDropdown.appendChild(option);
                });
            });
    });
</script>
