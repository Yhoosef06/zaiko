@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="container m-5">
        <div class="col-lg-10 bg-light shadow-sm p-sm-2">
            <label for="adding new item">
                <h1>Edit User Info</h1>
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
                            class="form-control @error('first_name')
                        border-danger @enderror"
                            value="{{ $user->first_name }}" placeholder="Unit Number">
                        @error('first_name')
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



                        <hr>
                        <a href="{{ route('view_users') }}" class="btn btn-outline-dark">Cancel</a>
                        <Button type="submit" class="btn btn-success">Save</Button>
                    </div>

                    <div class="col">
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

                        <a class="btn btn-dark" style="margin-top: 10px;"
                            href="{{ route('change_user_password', $user->id_number) }}">Change Password</a>

                    </div>

                </div>
            </form>
        </div>
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
