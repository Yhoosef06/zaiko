@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- Adding distance from the top navigation bar --}}
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12" style="max-width: 500px">
                    <div class="card text-lg p-5">
                        <div class="card-header">
                            <h3>Editing Profile Information</h3>
                        </div>
                        <form class="form-signin"
                            action="{{ route('save_edited_profile_info', ['id_number' => Auth::user()->id_number]) }}"
                            method="POST" enctype="multipart/form-data">

                            @csrf

                            <Label>ID Number:</Label>
                            <input class="form-control" type="text" name="" id=""
                                value=" {{ $user->id_number }}" disabled>

                            <Label>First Name:</Label>
                            <input class="form-control" type="text" name="first_name" id="first_name"
                                value="{{ $user->first_name }}">

                            <Label>Last Name:</Label>
                            <input class="form-control" type="text" name="last_name" id="last_name"
                                value="{{ $user->last_name }}">

                            <Label>Email Address:</Label>
                            <input class="form-control" type="text" name="email" id="email"
                                value="{{ $user->email }}" placeholder="Enter an email address">
                            <hr>
                            <div>
                                <a href="{{ route('view_profile', ['id_number' => Auth::user()->id_number]) }}"
                                    class="btn btn-outline-dark">Back</a>
                                <Button type="submit" class="btn btn-success"
                                    onclick="return confirm('You are about to save your edited profile information. Do you wish to continue?')">Save
                                    Changes</Button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    <!-- /.card -->
@endsection
