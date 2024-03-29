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

                <label for="email">Email Address:</label>
                <input type="text" id="email" name="email"
                    class="form-control @error('email')
                                                    border-danger @enderror"
                    value="{{ $user->email }}" placeholder="Enter an email address">


                <label for="last name">Change Password:</label>
                <a href="#" data-toggle="modal" data-target="#modal-change-user-password"
                    onclick="openEditUserPasswordModal('{{ $user->id_number }}')" class="form-control btn btn-default"
                    target="_blank">Click here</a>
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

                <label for="account status">Role:</label>
                <select id="role_id" name="role_id[]" class="form-control">
                    @foreach ($user->roles as $role)
                        <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                    @endforeach

                    @if (!$user->roles->contains('name', 'borrower'))
                        <option value="3">borrower</option>
                    @else
                        <option value="2">manager</option>
                    @endif
                </select>
                <label for="first name">Status:</label>
                <select id="isActive" name="isActive" class="form-control">
                    <option value="0" {{ $user->isActive == 0 ? 'selected' : '' }}>Inactive</option>
                    <option value="1" {{ $user->isActive == 1 ? 'selected' : '' }}>Active</option>
                </select>
                <br>
                <label class="scrollable-container-label" for="Item name">Select a department(s) to manage:</label>
                <div class="scrollable-container">
                    @foreach ($departments->groupBy('college.college_name') as $collegeName => $departmentsGroup)
                        <h5 class="text-decoration-underline">
                            {{ $collegeName }}
                        </h5>
                        <div class="department-container">
                            @foreach ($departmentsGroup as $department)
                                @php
                                    $isChecked = $user->departments->contains('id', $department->id);
                                @endphp
                                <input type="checkbox" class="department-checkbox" name="department_ids[]"
                                    value="{{ $department->id }}" {{ $isChecked ? 'checked' : '' }}>
                                {{ $department->department_name }}<br>
                            @endforeach
                        </div>
                    @endforeach
                </div>
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

    $(document).ready(function() {
        // Function to toggle department selection based on role
        function toggleDepartmentSelection() {
            var selectedRole = $('select[name="role_id[]"]').val();
            var departmentSection = $('.scrollable-container');
            var label = $('.scrollable-container-label')

            if (selectedRole === '2' || selectedRole === 'manager') {
                departmentSection.show();
                label.show(); // Show the department selection
            } else {
                departmentSection.hide();
                label.hide(); // Hide the department selection
            }
        }

        // Initially hide the department selection
        toggleDepartmentSelection();

        // Listen for changes in the role select
        $('select[name="role_id[]"]').change(function() {
            toggleDepartmentSelection(); // Toggle department selection on role change
        });

        // Additional code for checkbox functionality...
        // (Your existing checkbox functionality remains unchanged)
        $('.college-checkbox').change(function() {
            var collegeName = $(this).data('college');
            var isChecked = $(this).prop('checked');

            $('.department-checkbox[data-college="' + collegeName + '"]').prop('checked', isChecked);
        });

        $('.department-checkbox').change(function() {
            var collegeName = $(this).data('college');
            var departmentCheckboxes = $('.department-checkbox[data-college="' + collegeName + '"]');
            var collegeCheckbox = $('.college-checkbox[data-college="' + collegeName + '"]');

            collegeCheckbox.prop('checked', departmentCheckboxes.length === departmentCheckboxes.filter(
                ':checked').length);
        });
    });
</script>
<style>
    .scrollable-container {
        display: none;
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ccc;
        padding: 10px;
    }

    .scrollable-container-label {
        display: none;
    }

    .department-container {
        margin-bottom: 10px;
    }
</style>
