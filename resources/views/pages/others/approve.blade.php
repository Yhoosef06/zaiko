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
                    <div class="form-floating mb-3">
                        <h1 class="text-lg-start text-center">
                            Please have the admin approve your account
                        </h1>
                       
                        
                    </div>
                    
                    <a href="/"><button class="w-100 btn btn-lg btn-success" type="submit">Sign In</button></a>
                    <hr>
            </div>
        </div>
    </div>
@endsection
