@extends('pages.admin.home')

@section('content')
    <div class="container shadow-lg">
        <div class="container p-3">
            <div class="row text-lg">
                <div class="col">
                    <strong>I.D. Number:</strong> {{ $user->id_number }} <br>
                    <strong>First Name:</strong> {{ $user->first_name }} <br>
                    <strong>Last Name:</strong> {{ $user->last_name }} <br>
                    <strong>Account Type:</strong> {{ $user->account_type }} <br>
                    <strong>Account Status:</strong> {{ $user->account_status }} <br>
                </div>

                <div class="col">
                    <strong>Front of ID:</strong> {{ $user->front_of_id }} <br>
                    <strong>Back of ID:</strong> {{ $user->back_of_id }} <br>
                </div>
            </div>
            <hr>
            <a href="{{ route('view_users') }}" class="btn btn-outline-dark">Back</a>
        </div>
    </div>
@endsection
