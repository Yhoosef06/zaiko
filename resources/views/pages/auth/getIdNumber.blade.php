@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <form class="form-signin" action="{{ route('security_questions', ['id_number' => $id_number]) }}" method="GET"
        enctype="multipart/form-data">
        @csrf
        @if (session('message'))
            <div class="alert alert-danger alert-dismissible">
                <i class="icon fas fa-exclamation-triangle"></i> {{ session('message') }}
            </div>
        @endif
        <h1 class="header">Zaiko.</h1>
        <h5>Forgot Password?</h5>

        <label for="inputIdNumber" class="sr-only">I.D. Number</label>
        <input type="text" id="id_number" name="id_number"
            class="form-control @error('id_number') border-danger @enderror" placeholder="Your I.D. Number">
        @error('id_number')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror

        <hr>
        <a href="{{ route('signin.page') }}" class="btn btn-md btn-outline-success">Cancel</a>
        <button class="btn btn-md btn-success btn-block" type="submit">Proceed</button>
    </form>
@endsection
