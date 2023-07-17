@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: rgb(190, 203, 201);
        }
    </style>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-7 text-center text-lg-start">
                <h1 class="display-4 fw-bold lh-1 mb-3">Zaiko.</h1>
                <p class="col-lg-10 fs-4">Manage, track and maintain your laboratory assets.</p>
            </div>
            <div class="col-md-10 mx-auto col-lg-5">
                <form class="p-4 p-md-5 border rounded-3 bg-light" method="POST" action="{{ route('signin') }}">

                    @if (session('status'))
                        <div class=" danger">
                            <p>{{ session('status') }}</p>
                        </div>
                    @endif

                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control @error('id_number') border-danger @enderror" name="id_number"
                            id="id_number" placeholder="I.D. Number">
                        <label for="floatingInput">I.D. Number</label>
                        @error('id_number')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') border-danger @enderror"
                            name="password" id="password" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                        @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <div>
                            <a href="#">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="w-100 btn btn-lg btn-success" type="submit">Sign In</button>
                    <hr>
                    <a href="{{ route('register') }}" class="w-100 btn btn-lg btn-outline-success">Register</a>
                </form>
            </div>
        </div>
    </div>
@endsection
