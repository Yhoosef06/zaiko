@extends('layouts.students.layout')

{{-- nav --}}
@section('nav')
    @include('layouts.students.mainnav')
    @include('layouts.students.sidenav')
@endsection

{{-- footer --}}
@section('footer')
    @include('layouts.students.footer')
@endsection
