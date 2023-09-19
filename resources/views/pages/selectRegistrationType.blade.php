@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <div class="container" style="max-width: 500px">
        <div class="container-fluid text-center">
            <div class="card">
                <div class="card-header">
                    <h5>Choose a account type</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('student_registration') }}" class="btn btn-lg btn-success">Student</a>
                    <span>or</span>
                    <a href="{{ route('faculty_registration') }}" class="btn btn-lg btn-success">Faculty</a>
                </div>
                <div class="card-footer">
                    <a href="{{ route('signin.page') }}" class="btn btn-md btn-dark">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
