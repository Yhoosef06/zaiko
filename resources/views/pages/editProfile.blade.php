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
                <div class="col-6">
                    <div class="card text-lg p-5">
                        <div class="card-header">
                            <h3>Editing Profile Information</h3>
                        </div>
                        <form class="form-signin"
                            action="{{ route('save_edited_profile_info', ['id_number' => Auth::user()->id_number]) }}"
                            method="POST" enctype="multipart/form-data">

                            @csrf

                            <Label>ID Number:</Label>
                            <input class="form-control" type="text" name="" id=""
                                value=" {{ $user->id_number }}" disabled>

                            <Label>First Name:</Label>
                            <input class="form-control" type="text" name="first_name" id="first_name"
                                value="{{ $user->first_name }}">

                            <Label>Last Name:</Label>
                            <input class="form-control" type="text" name="last_name" id="last_name"
                                value="{{ $user->last_name }}">

                            <label>
                                {{ Auth::user()->account_type == 'student' ? 'Program:' : 'Department:' }}
                            </label>
                            <select id="department_id" name="department_id"
                                class="form-control @error('department_id') border-danger @enderror">
                                <option value="" disabled>Select a Program</option>
                                @foreach ($departments->groupBy('college_name') as $collegeName => $departmentsGroup)
                                    <optgroup label="{{ $collegeName }}">
                                        @foreach ($departmentsGroup as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department_id') == $department->id || Auth::user()->department == $department->id ? 'selected' : '' }}>
                                                {{ $department->department_name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>

                            <hr>
                            <div>
                                <a href="{{ route('view_profile', ['id_number' => Auth::user()->id_number]) }}"
                                    class="btn btn-outline-dark">Back</a>
                                <Button type="submit" class="btn btn-success"
                                    onclick="return confirm('You are about to save your edited profile information. Do you wish to continue?')">Save Changes</Button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    <!-- /.card -->
@endsection
