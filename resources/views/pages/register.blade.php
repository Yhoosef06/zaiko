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
        <H5>Register an Account</H5>

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

        <label for="" class="sr-only">Password</label>
        <input type="password" name="password" id="password"
            class="form-control @error('password') border-danger @enderror" placeholder="Password">
        @error('password')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="" class="sr-only">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            class="form-control @error('password_confirmation') border-danger @enderror" placeholder="Confirm Password">
        @error('password_confirmation')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="" class="sr-only">Upload Front of ID</label>
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
        @enderror

        <hr>
        <a href="{{ route('signin.page') }}" class="btn btn-md btn-outline-success">Cancel</a>
        <button class="btn btn-md btn-success btn-block" type="submit">Submit</button>
    </form>
@endsection
