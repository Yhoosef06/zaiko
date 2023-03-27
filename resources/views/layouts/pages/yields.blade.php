@extends('layouts.pages.layout')

{{-- nav --}}
@section('nav')
    @include('layouts.pages.mainnav')
    @include('layouts.pages.sidenav')
@endsection

{{-- footer --}}
@section('footer')
    @include('layouts.pages.footer')
@endsection
