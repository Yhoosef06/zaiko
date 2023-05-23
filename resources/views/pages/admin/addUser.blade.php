@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="container alert bg-gradient-lightblue text-center text-sm">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="container m-2">
        <div class="container col-lg-10 bg-light shadow-sm p-3">
            <label for="adding new item">
                <h2 class="text-decoration-underline">Adding New User</h2>
            </label>
            <form action="{{ route('save_new_user') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="I.D. Number">I.D. Number:</label>
                        <input type="text" id="id_number" name="id_number" value="{{ old('id_number') }}"
                            class="form-control col-sm-4 @error('id_number')
                        border-danger
                        @enderror"
                            placeholder="I.D. Number">
                        @error('id_number')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="first name">First Name:</label>
                        <input type="text" id="first_name" name="first_name"
                            class="form-control @error('first_name')
                        border-danger @enderror"
                            value="{{ old('first_name') }}" placeholder="First Name">
                        @error('first_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="last name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name"
                            class="form-control @error('last_name')
                        border-danger @enderror"
                            value="{{ old('last_name') }}" placeholder="Last Name">
                        @error('last_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="account type">Account Type:</label>
                        <select id="account_type" name="account_type" class="form-control">
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                            <option value="faculty">Faculty</option>
                            <option value="reads">Reads</option>
                        </select>

                        <label for="account status">Account Status:</label>
                        <select id="account_status" name="account_status" class="form-control">
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div class="col">
                        <label for="Item name">College Department:</label>
                        @if (isset($departments))
                        <select id="department_id" name="department_id" class="form-control col-sm-8 @error('department_id') border-danger @enderror">
                            <option value="" disabled selected>Select College Department</option>
                            @foreach ($departments->groupBy('college_name') as $collegeName => $departmentsGroup)
                                <optgroup label="{{ $collegeName }}">
                                    @foreach ($departmentsGroup as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @endif

                        @error('department_id')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror


                        <label for="">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') border-danger @enderror" placeholder="Password">
                        @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control @error('password_confirmation') border-danger @enderror"
                            placeholder="Confirm Password">
                        @error('password_confirmation')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <hr>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                        <Button type="submit" class="btn btn-success"
                            onclick="return confirm('You are about to create a new user. Do you wish to continue?')">Save</Button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
