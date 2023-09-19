@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <div class="container" style="max-width: 500px">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('student_registration') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <H5>Registering as a Student</H5>

                    <label for="inputIdNumber" class="sr-only">I.D. Number</label>
                    <input type="text" id="id_number" value="{{ old('id_number') }}" name="id_number"
                        class="form-control @error('id_number') border-danger @enderror" placeholder="I.D. Number">
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
                    <input type="text" value="{{ old('first_name') }}" id="first_name" name="first_name"
                        class="form-control  @error('first_name') border-danger @enderror" placeholder="First Name">
                    @error('first_name')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="" class="sr-only">Last Name</label>
                    <input type="text" value="{{ old('last_name') }}" name="last_name" id="last_name"
                        class="form-control @error('last_name') border-danger @enderror" placeholder="Last Name">
                    @error('last_name')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Item name">Program:</label>
                    <select id="department_id" name="department_id"
                        class="form-control col-sm-8 @error('department_id') border-danger @enderror">
                        <option value="" disabled selected>Select a Program</option>
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
                        class="form-control @error('password_confirmation') border-danger @enderror"
                        placeholder="Confirm Password">
                    @error('password_confirmation')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- <label for="Item name">Password Security Question:</label>
                    <select name="question" id="question" class="form-control  @error('question') border-danger @enderror">
                        <option value="">Select a security question</option>
                        @foreach ($securityQuestions as $question)
                            <option value="{{ $question->id }}"  
                                {{ old('question') == $question->id ? 'selected' : '' }}>{{ $question->question }}</option>
                        @endforeach
                    </select>
                    @error('question')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
            
                    <label for="" class="sr-only">Your Answer:</label>
                    <input type="text" value="{{ old('answer') }}" name="answer" id="answer"
                        class="form-control @error('answer') border-danger @enderror" placeholder="Your answer">
                    @error('answer')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror --}}
                    <hr>
                    <a href="{{ route('select_registration_type') }}" class="btn btn-md btn-outline-success">Back</a>
                    <button class="btn btn-md btn-success btn-block" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
