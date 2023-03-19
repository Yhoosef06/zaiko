@extends('pages.admin.home')

@section('content')
    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="container m-5">
        <div class="col-lg-10 bg-light shadow-sm p-5">
            <label for="adding new item">
                <h1>Adding New User</h1>
            </label>
            <form action="{{ route('update_user_info', $user->id_number) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <input type="checkbox" id="edit_id" onclick="edit()"> Edit I.D. Number <br>
                        <label for="I.D. Number">I.D. Number:</label>
                        <input type="text" id="id_number" name="id_number" value="{{ $user->id_number }}" disabled
                            class="form-control col-sm-4 @error('id_number')
                        border-danger
                        @enderror">
                        @error('id_number')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="first name">First Name:</label>
                        <input type="text" id="first_name" name="first_name"
                            class="form-control @error('first_name')
                        border-danger @enderror"
                            value="{{ $user->first_name }}" placeholder="Unit Number">
                        @error('first_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="last name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name"
                            class="form-control @error('last_name')
                        border-danger @enderror"
                            value="{{ $user->last_name }}" placeholder="Unit Number">
                        @error('last_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="account type">Account Type:</label>
                        <select id="account_type" name="account_type" class="form-control">
                            @if ($user->account_type == 'student')
                                <option value="student">Student</option>
                                <option value="admin">Admin</option>
                            @else
                                <option value="admin">Admin</option>
                                <option value="student">Student</option>
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


                    </div>

                    <div class="col">
                        <input type="checkbox" id="change_pass" onclick="changepass()"> Change password
                        <br>
                        <label for="">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control password @error('password') border-danger @enderror"
                            value="{{ $user->password }}" placeholder="Password" disabled>
                        @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control password @error('password_confirmation') border-danger @enderror"
                            value="{{ $user->password }}" placeholder="Confirm Password" disabled>
                        @error('password_confirmation')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <hr>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                        <Button type="submit" class="btn btn-success">Submit</Button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    function changepass() {
        if ($("#change_pass").is(":checked")) {
            document.getElementById("password").disabled = false;
            document.getElementById("password_confirmation").disabled = false;
        } else {
            document.getElementById("password").disabled = true;
            document.getElementById("password_confirmation").disabled = true;
        }
    }

    function edit() {
        if ($("#edit_id").is(":checked")) {
            document.getElementById("id_number").disabled = false;
        } else {
            document.getElementById("id_number").disabled = true;
        }
    }
</script>
