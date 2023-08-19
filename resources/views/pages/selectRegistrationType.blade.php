@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <form class="form-signin" action="#" method="GET" enctype="multipart/form-data">
        @csrf
        @if (session('message'))
            <div class="alert alert-danger alert-dismissible">
                <i class="icon fas fa-exclamation-triangle"></i> {{ session('message') }}
            </div>
        @endif
        <div class="text-center">
            <h5>Register as a?</h5>
            <a href="{{ route('student_registration') }}" class="btn btn-lg btn-success">Student</a> or <a href="{{ route('faculty_registration') }}" class="btn btn-lg btn-success">Faculty</a>
        </div>
        <hr>
        <a href="{{ route('signin.page') }}" class="btn btn-md btn-dark">Go Back</a>
    </form>
@endsection
