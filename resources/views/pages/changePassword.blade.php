@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <form class="form-signin" action="{{ route('verify') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (session('message'))
            <div class="alert alert-danger alert-dismissible">
                <i class="icon fas fa-exclamation-triangle"></i> {{ session('message') }}
            </div>
        @endif
        <H1 class="header">Zaiko.</H1>
        <H5>Change Password</H5>

        <label for="inputIdNumber" class="sr-only">New Password</label>
        <input type="" id="new_password" name="id_number"
            class="form-control @error('id_number') border-danger @enderror" placeholder="I.D. Number">
        @error('id_number')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <label for="" class="sr-only">Answer:</label>
        <input type="" name="answer" id="answer" class="form-control @error('answer') border-danger @enderror"
            placeholder="Your answer">
        @error('answer')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <hr>
        <a href="{{ route('signin.page') }}" class="btn btn-md btn-outline-success">Cancel</a>
        <button class="btn btn-md btn-success btn-block" type="submit">Save</button>
    </form>
@endsection
