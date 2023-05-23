@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif

    <div class="container col-lg-10 bg-light shadow-sm p-sm-2">
        <label for="adding new item">
            <h2>Edit User Info</h2>
        </label>
        <form action="{{ route('update_user_info', $user->id_number) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col">
                    <label for="I.D. Number">I.D. Number:</label>
                    <input type="text" id="id_number" name="id_number" value="{{ $user->id_number }}" disabled
                        class="form-control col-sm-4 @error('id_number')
                            border-danger
                            @enderror">
                    <input type="checkbox" id="edit_id" onclick="edit()"> Edit I.D. Number <br>
                    @error('id_number')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror


                    <label for="first name">First Name:</label>
                    <input type="text" id="first_name" name="first_name"
                        class="form-control col-sm-7 @error('first_name')
                        border-danger @enderror"
                        value="{{ $user->first_name }}" placeholder="Unit Number">
                    @error('first_name')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="account type">Account Type:</label>
                    <select id="account_type" name="account_type" class="form-control col-sm-7">
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
                </div>

                <div class="col">
                    <label for="last name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name"
                        class="form-control col-sm-7 @error('last_name')
                        border-danger @enderror"
                        value="{{ $user->last_name }}" placeholder="Unit Number">
                    @error('last_name')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="account status">Account Status:</label>
                    <select id="account_status" name="account_status" class="form-control col-sm-7">
                        @if ($user->account_status == 'pending')
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                        @else
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                        @endif
                    </select>

                    <a class="btn btn-dark" style="margin-top: 10px;"
                        href="{{ route('change_user_password', $user->id_number) }}">Change Password</a>
                    <hr>
                    <a href="{{ route('view_users') }}" class="btn btn-outline-dark">Back</a>
                    <Button type="submit" class="btn btn-success" onclick="return confirm('Do you wish to continue updating this user?')">Save Changes</Button>
                </div>

            </div>
        </form>
    </div>
@endsection

<script>
    function edit() {
        if ($("#edit_id").is(":checked")) {
            document.getElementById("id_number").disabled = false;
        } else {
            document.getElementById("id_number").disabled = true;
        }
    }
</script>
