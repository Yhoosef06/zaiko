@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">Adding New {{ Auth::user()->account_type == 'faculty' ? 'Student' : 'User' }}</h1> --}}
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
                        <form action="{{ route('save_new_user') }}" method="POST">
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
                                    </div>

                                    <div class="col">
                                        <label for="account type">Account Type:</label>
                                        <select id="account_type" name="account_type" class="form-control">
                                            <option value="student" selected>student</option>
                                            @if (Auth::user()->account_type == 'admin')
                                                <option value="admin">admin</option>
                                            @endif
                                            <option value="faculty">faculty</option>
                                            {{-- <option value="reads">reads</option> --}}
                                        </select>

                                        <label for="account status">Account Status:</label>
                                        <select id="account_status" name="account_status" class="form-control">
                                            <option value="approved" selected>approved</option>
                                            <option value="pending">ending</option>
                                        </select>

                                        <label for="account status">Role:</label>
                                        <select id="role" name="role" class="form-control">
                                            <option value="borrower" selected>borrower</option>
                                            <option value="manager">manager</option>
                                        </select>

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
