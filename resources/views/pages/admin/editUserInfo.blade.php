<form action="{{ route('update_user_info', $user->id_number) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col">
                <label for="I.D. Number">I.D. Number:</label>
                <input type="text" id="id_number" name="id_number" value="{{ $user->id_number }}" disabled
                    class="form-control">
                {{-- <input type="checkbox" id="edit_id" onclick="edit()"> Edit I.D. Number <br> --}}

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

                {{-- <label>Program/Department:</label>
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
                @endif --}}
            </div>

            <div class="col">
                <label for="account type">Account Type:</label>
                <select id="account_type" name="account_type" class="form-control">
                    @if ($user->account_type == 'student')
                        <option value="student" selected>student</option>
                        <option value="faculty">faculty</option>
                    @elseif ($user->account_type == 'faculty')
                        <option value="faculty" selected>faculty</option>
                        <option value="student">student</option>
                    @endif
                </select>

                <label for="account status">Account Status:</label>
                <select id="account_status" name="account_status" class="form-control">
                    @if ($user->account_status == 'pending')
                        <option value="pending" selected>pending</option>
                        <option value="approved">approved</option>
                    @else
                        <option value="approved" selected>approved</option>
                        <option value="pending">pending</option>
                    @endif
                </select>

                <label for="account status">Role:</label>
                <select id="role" name="role" class="form-control">
                    @foreach ($user->roles as $role)
                        <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                    @endforeach

                    @if (!$user->roles->contains('name', 'borrower'))
                        <option value="3">borrower</option>
                    @else
                        <option value="2">manager</option>
                    @endif
                </select>
                <br>
                <a href="#" data-toggle="modal" data-target="#modal-change-user-password"
                    onclick="openEditUserPasswordModal('{{ $user->id_number }}')" class="form-control btn btn-default"
                    target="_blank">Change Password</a>
                <hr>
                <button type="button" class="btn btn-dark" data-dismiss="modal">
                    Close
                </button>
                <Button type="submit" class="btn btn-success"
                    onclick="return confirm('You are about to save changes. Do you wish to continue?')">Save
                    Changes</Button>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</form>

<div class="modal fade" id="modal-change-user-password" tabindex="-1" role="dialog"
    aria-labelledby="modal-change-user-password">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-change-user-password">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script>
    function edit() {
        if ($("#edit_id").is(":checked")) {
            document.getElementById("id_number").disabled = false;
        } else {
            document.getElementById("id_number").disabled = true;
        }
    }

    function openEditUserPasswordModal(userId) {
        var modal = $('#modal-change-user-password');
        var url = "{{ route('change_user_password', ['id_number' => ':userId']) }}".replace(':userId', userId);
        // Clear previous content from the modal
        modal.find('.modal-body').html('');

        $.get(url, function(data) {
            modal.find('.modal-body').html(data);
        });
    }
</script>
