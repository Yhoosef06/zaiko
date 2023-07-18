@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <form class="form-signin" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <H1 class="header">Zaiko.</H1>
        <H5>Register as a Student</H5>

        <label for="inputIdNumber" class="sr-only">I.D. Number</label>
        <input type="" id="id_number" name="id_number" class="form-control @error('id_number') border-danger @enderror"
            placeholder="I.D. Number">
        @error('id_number')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
        @if (session('status'))
            <div class="text-danger">
                {{ session('status') }}
            </div>
        @endif

        <label for="" class="sr-only">First Name</label>
        <input type="" id="first_name" name="first_name"
            class="form-control @error('first_name') border-danger @enderror" placeholder="First Name">
        @error('first_name')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="" class="sr-only">Last Name</label>
        <input type="" name="last_name" id="last_name"
            class="form-control @error('last_name') border-danger @enderror" placeholder="Last Name">
        @error('last_name')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="Item name">Degree Program:</label>
        <select id="department_id" name="department_id"
            class="form-control col-sm-8 @error('department_id') border-danger @enderror">
            <option value="" disabled selected>Select Degree Program</option>
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
        @error('department_id')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="" class="sr-only">Password:</label>
        <input type="password" name="password" id="password"
            class="form-control @error('password') border-danger @enderror" placeholder="Password">
        @error('password')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="" class="sr-only">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            class="form-control @error('password_confirmation') border-danger @enderror" placeholder="Confirm Password">
        @error('password_confirmation')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="" class="sr-only">Security Question:</label>
        <select id="security_question" name="security_question"
            class="form-control col-sm-8">
            <option value="" disabled selected>Select a security question</option>
            <option value="1">What was your favorite subject in high school?</option>
            <option value="2">What is the name of the road you grew up on?</option>
            <option value="3">What is your favorite musical genre?</option>
        </select>

        <label for="" class="sr-only">Your Answer:</label>
        <input type="text" class="form-control" name="your_answer" id="your_answer" placeholder="Your answer">

        {{-- <label for="" class="sr-only">Upload Front of ID</label>
        <input type="file" name="front_of_id" id="front_of_id"
            class="form-control @error('front_of_id') border-danger @enderror" placeholder="Upload Front of ID">
        @error('front_of_id')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="" class="sr-only">Upload Back of ID</label>
        <input type="file" name="back_of_id" id="back_of_id"
            class="form-control @error('back_of_id') border-danger @enderror" placeholder="Upload Back of ID">
        @error('back_of_id')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror --}}

        <hr>
        <a href="{{ route('signin.page') }}" class="btn btn-md btn-outline-success">Cancel</a>
        <button class="btn btn-md btn-success btn-block" type="submit">Submit</button>
        <a href="{{ route('register-faculty') }}" class="btn btn-md btn-dark">Register as a Faculty</a>
    </form>
@endsection
