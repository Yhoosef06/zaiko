<form action="{{ route('update_user_info', $user->id_number) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col">
                <label for="I.D. Number">I.D. Number:</label>
                <input type="text" id="id_number" name="id_number" value="{{ $user->id_number }}" disabled
                    class="form-control">
                <input type="checkbox" id="edit_id" onclick="edit()"> Edit I.D. Number <br>

                <label for="first name">First Name:</label>
                <input type="text" id="first_name" name="first_name"
                    class="form-control @error('first_name')
                                            border-danger @enderror"
                    value="{{ $user->first_name }}" placeholder="Unit Number">

                <label for="last name">Last Name:</label>
                <input type="text" id="last_name" name="last_name"
                    class="form-control @error('last_name')
                                                border-danger @enderror"
                    value="{{ $user->last_name }}">

                <label>Program/Department:</label>
                @if (isset($departments))
                    <select id="department_id" name="department_id"
                        class="form-control @error('department_id') border-danger @enderror">
                        <option value="{{ $user->department_id }}" selected>
                            {{ $user->departments->department_name }}</option>
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
            </div>

            <div class="col">

                <label for="account type">Account Type:</label>
                <select id="account_type" name="account_type" class="form-control">
                    @if ($user->account_type == 'student')
                        <option value="student">Student</option>
                        <option value="admin">Admin</option>
                        <option value="reads">Reads</option>
                        <option value="faculty">Faculty</option>
                    @elseif ($user->account_type == 'admin')
                        <option value="admin">Admin</option>
                        <option value="student">Student</option>
                        <option value="reads">Reads</option>
                        <option value="faculty">Faculty</option>
                    @elseif ($user->account_type == 'faculty')
                        <option value="faculty">Faculty</option>
                        <option value="reads">Reads</option>
                        <option value="admin">Admin</option>
                        <option value="student">Student</option>
                    @else
                        <option value="reads">Reads</option>
                        <option value="admin">Admin</option>
                        <option value="student">Student</option>
                        <option value="faculty">Faculty</option>
                    @endif
                </select>

                <label for="account status">Account Status:</label>
                <select id="account_status" name="account_status" class="form-control">
                    @if ($user->account_status == 'pending')
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                    @else
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                    @endif
                </select>

                <label for="account status">Role:</label>
                <select id="role" name="role" class="form-control">
                    <option value="borrower">borrower</option>
                    <option value="manager">manager</option>
                </select>
                <br>
                <a href="{{ route('change_user_password', ['id_number' => $user->id_number]) }}"
                    class="form-control btn btn-default">Change Password</a>
                <hr>
                <button type="button" class="btn btn-dark" data-dismiss="modal">
                    Close
                </button>
                <Button type="submit" class="btn btn-success"
                    onclick="return confirm('You have made changes this user. Do you wish to continue?')">Save
                    Changes</Button>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</form>

<script>
    function edit() {
        if ($("#edit_id").is(":checked")) {
            document.getElementById("id_number").disabled = false;
        } else {
            document.getElementById("id_number").disabled = true;
        }
    }
</script>
