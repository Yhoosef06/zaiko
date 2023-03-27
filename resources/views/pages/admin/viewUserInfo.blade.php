@extends('pages.admin.home')

@section('content')
    <div class="container shadow-lg">
        <div class="container p-3">
            <div class="row text-lg">
                <div class="col">
                    <strong>I.D. Number:</strong> {{ $user->id_number }} <br>
                    <strong>First Name:</strong> {{ $user->first_name }} <br>
                    <strong>Last Name:</strong> {{ $user->last_name }} <br>
                    @if ($user->account_type == 'student')
                        <strong>Account Type:</strong> {{ 'Student' }} <br>
                    @else
                        <strong>Account Type:</strong> {{ 'Admin' }} <br>
                    @endif

                    @if ($user->account_status == 'pending')
                        <strong>Account Status:</strong> {{ 'Pending' }} <br>
                    @else
                        <strong>Account Status:</strong> {{ 'Approved' }} <br>
                    @endif
                </div>

                <div class="col">
                    <strong>Front of ID:</strong><br>
                    @if ($user->front_of_id === 'null')
                        <div class="border border-1" style="height: 120px; width:100px">
                            <p class="mt-5 text-sm text-center">
                                No image.
                            </p>
                        </div>
                    @else
                        <img src="{{ asset('storage/ids/' . $user->id_number . 'frontID.jpg') }}"
                            style="height:120px; width: 100px">
                    @endif
                    <br>
                    <strong>Back of ID:</strong> <br>
                    @if ($user->back_of_id === 'null')
                        <div class="border border-1" style="height: 120px; width:100px">
                            <p class="mt-5 text-sm text-center">
                                No image.
                            </p>
                        </div>
                    @else
                        <img src="{{ asset('storage/ids/' . $user->id_number . 'backID.jpg') }}"
                            style="height:120px; width: 100px">
                    @endif
                </div>
            </div>
            <hr>
            <a href="{{ route('view_users') }}" class="btn btn-outline-dark">Back</a>
        </div>
    </div>
@endsection
