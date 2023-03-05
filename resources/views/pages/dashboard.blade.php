@extends('layouts.app')

@section('content')
    <h1>
        @auth
        {{Auth::user()->last_name}}
        {{auth()->user()->last_name}}
        @endauth
    </h1>
@endsection