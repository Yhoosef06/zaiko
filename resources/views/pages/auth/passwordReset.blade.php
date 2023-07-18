@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <form class="form-signin" action="{{ route('reset_password', $id_number) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (session('message'))
            <div class="alert alert-danger alert-dismissible">
                <i class="icon fas fa-exclamation-triangle"></i> {{ session('message') }}
            </div>
        @endif
        <H1 class="header">Zaiko.</H1>
        <H5>Reset Password</H5>

        <label for="" class="sr-only">New Password:</label>
        <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') border-danger @enderror"
            placeholder="Your new password">
        @error('new_password')
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

        <hr>
        <a href="{{ route('signin.page') }}" class="btn btn-md btn-outline-success">Cancel</a>
        <button class="btn btn-md btn-success btn-block" type="submit">Save</button>
    </form>
@endsection
