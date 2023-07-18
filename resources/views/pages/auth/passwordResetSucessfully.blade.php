@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <div class="form-signin text-center">
        <H1 class="header">Zaiko.</H1>
        <H5>Password Reset Successful.</H5>
        <a href="{{ route('signin.page') }}" class="btn btn-md btn-success">Sign In</a>
    </div>
@endsection
