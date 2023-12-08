@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Adding New User</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12" style="max-width: 1000px">
                    <div class="card">
                        <form id="addNewUser" method="POST">
                            {{-- <form action="{{route('save_new_user')}}" method="POST"> --}}
                            @csrf
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                                    </div>
                                @elseif (session('danger'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col">
                                        <label for="I.D. Number">I.D. Number:</label>
                                        <input type="text" id="id_number" name="id_number" value="{{ old('id_number') }}"
                                            class="form-control col-sm- @error('id_number')
                                        border-danger
                                        @enderror"
                                            placeholder="I.D. Number" required>
                                        @error('id_number')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="first name">First Name:</label>
                                        <input type="text" id="first_name" name="first_name"
                                            class="form-control @error('first_name')
                                        border-danger @enderror"
                                            value="{{ old('first_name') }}" placeholder="First Name" required>
                                        @error('first_name')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="account status">Role:</label>
                                        <select name="role_id[]" class="form-control" required>
                                            <option selected disabled>Select a role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>

                                        <label class="scrollable-container-label" for="Item name">Select a department(s) to
                                            manage:</label>
                                        <div class="scrollable-container">
                                            @foreach ($departments->groupBy('college_name') as $collegeName => $departmentsGroup)
                                                <h5 class="text-decoration-underline">
                                                    <input type="checkbox" class="college-checkbox"
                                                        data-college="{{ $collegeName }}">
                                                    {{ $collegeName }}
                                                </h5>
                                                <div class="department-container">
                                                    @foreach ($departmentsGroup as $department)
                                                        <input type="checkbox" class="department-checkbox"
                                                            name="department_ids[]" data-college="{{ $collegeName }}"
                                                            value="{{ $department->id }}">
                                                        {{ $department->department_name }}<br>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label for="account type">Account Type:</label>
                                        <select id="account_type" name="account_type" class="form-control" required>
                                            <option selected disabled>Select an account type</option>
                                            <option value="student">student</option>
                                            <option value="faculty">faculty</option>
                                            {{-- <option value="reads">reads</option> --}}
                                        </select>

                                        <label for="last name">Last Name:</label>
                                        <input type="text" id="last_name" name="last_name"
                                            class="form-control @error('last_name')
                                        border-danger @enderror"
                                            value="{{ old('last_name') }}" placeholder="Last Name" required>
                                        @error('last_name')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="email address">Email Address:</label>
                                        <input type="text" id="email" name="email"
                                            class="form-control @error('email')
                                        border-danger @enderror"
                                            value="{{ old('email') }}" placeholder="Email Address" required>
                                        @error('email')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <hr>
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                                        <Button type="submit" class="btn btn-success">Save</Button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    <!-- /.card -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#addNewUser').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();

                Swal.fire({
                    title: 'Please review all entries before proceeding.',
                    text: 'Do you wish to continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('save_new_user') }}",
                            type: "POST",
                            data: formData,
                            success: function(response) {
                                console.log(response);
                                if (response.success) {
                                    Swal.fire(
                                        'Success',
                                        'User Successfully Added.',
                                        'success'
                                    ).then(() => {
                                        window.location.href =
                                            "{{ url('add-new-user') }}";
                                    });
                                } else if (response.error) {
                                    Swal.fire(
                                        'Error',
                                        response.error,
                                        'error'
                                    );
                                } else if (response.emptyRole || response
                                    .emptyAccountType) {
                                    Swal.fire(
                                        'Error',
                                        response.emptyRole || response
                                        .emptyAccountType,
                                        'error'
                                    );
                                } else if (response.duplicate) {
                                    Swal.fire(
                                        'Error',
                                        response.duplicate,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                var errors = xhr.responseJSON.errors;
                                if (errors && errors.email) {
                                    Swal.fire(
                                        'Error',
                                        errors.email[0],
                                        'error'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error',
                                        'An error occurred while processing the request.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            function toggleDepartmentSelection() {
                var selectedRole = $('select[name="role_id[]"]').val();
                var departmentSection = $('.scrollable-container');
                var label = $('.scrollable-container-label')

                if (selectedRole === '2' || selectedRole === 'manager') {
                    departmentSection.show();
                    label.show();
                } else {
                    departmentSection.hide();
                    label.hide();
                }
            }

            toggleDepartmentSelection();

            $('select[name="role_id[]"]').change(function() {
                toggleDepartmentSelection();
            });

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
@endsection
