@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- Adding distance from the top navigation bar --}}
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                                </div>
                            @elseif (session('danger'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                                </div>
                            @endif
                            
                            <h3>Adding New {{ Auth::user()->account_type == 'faculty'  ? 'Student' : 'User' }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('save_new_user') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <label for="I.D. Number">I.D. Number:</label>
                                        <input type="text" id="id_number" name="id_number" value="{{ old('id_number') }}"
                                            class="form-control col-sm- @error('id_number')
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
                                            <option value="student">student</option>
                                            <option value="admin">admin</option>
                                            <option value="faculty">faculty</option>
                                            <option value="reads">reads</option>
                                        </select>

                                        <label for="account status">Account Status:</label>
                                        <select id="account_status" name="account_status" class="form-control">
                                            <option value="approved">approved</option>
                                            <option value="pending">pending</option>
                                        </select>

                                        <label for="account status">Role:</label>
                                        <select id="role" name="role" class="form-control">
                                            <option value="borrower">borrower</option>
                                            <option value="manager">manager</option>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <label for="Item name">Program/Department:</label>
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

                                        @error('department_id')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror


                                        <label for="">Password</label>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') border-danger @enderror"
                                            placeholder="Password">
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

                                        <label for="Item name">Password Security Question:</label>
                                        <select name="question" id="question"
                                            class="form-control  @error('question') border-danger @enderror">
                                            <option value="">Select a security question</option>
                                            @foreach ($securityQuestions as $question)
                                                <option value="{{ $question->id }}"
                                                    {{ old('question') == $question->id ? 'selected' : '' }}>
                                                    {{ $question->question }}</option>
                                            @endforeach
                                        </select>
                                        @error('question')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <label for="">Answer:</label>
                                        <input type="text" value="{{ old('answer') }}" name="answer" id="answer"
                                            class="form-control @error('answer') border-danger @enderror"
                                            placeholder="Your answer">
                                        @error('answer')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <hr>
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                                        <Button type="submit" class="btn btn-success"
                                            onclick="return confirm('Please review all entries before proceeding. Do you wish to continue?')">Save</Button>
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
@endsection
