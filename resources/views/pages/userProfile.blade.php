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
                    <div class="card text-lg p-3">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                            </div>
                        @endif

                        <div class="card-title">
                            <h3>Profile</h3>
                        </div>
                        <div class="card card-success card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                            href="#custom-tabs-four-profile" role="tab"
                                            aria-controls="custom-tabs-four-profile" aria-selected="false">
                                            Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill"
                                            href="#custom-tabs-four-settings" role="tab"
                                            aria-controls="custom-tabs-four-settings" aria-selected="false">
                                            Security</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-profile-tab">
                                        <div class="container">
                                            <Label>ID Number:</Label>
                                            {{ $user->id_number }}
                                        </div>
                                        <div class="container">
                                            <Label>First Name:</Label>
                                            {{ $user->first_name }}
                                        </div>
                                        <div class="container">
                                            <Label>Last Name:</Label>
                                            {{ $user->last_name }}
                                        </div>
                                        <div class="container">
                                            <Label>Email Address:</Label>
                                            {{ $user->email ? $user->email : 'None' }}
                                        </div>
                                        @if (Auth::user()->roles->contains('name', 'manager'))
                                            <div class="container">
                                                <Label>Department(s) to manage:</Label>
                                                @foreach ($user->departments as $key => $department)
                                                    {{ $department->department_name }}
                                                    @if ($key < count($user->departments) - 1)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        <hr>
                                        <div class="text-right">
                                            <a href="{{ route('edit_profile', ['id_number' => Auth::user()->id_number]) }}"
                                                class="btn btn-primary">Edit</a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-settings-tab">
                                        <div class="container">
                                            <label for="">Password Setting:</label>
                                            <a href="{{ route('change_user_password', ['id_number' => Auth::user()->id_number]) }}"
                                                class="text-decoration-underline">Change Password</a>
                                        </div>
                                        <div class="container">
                                            <label for="">Security Question:</label>
                                            <a href="{{ route('modify_security_question', ['id_number' => Auth::user()->id_number]) }}"
                                                class="text-decoration-underline">Update</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <div>
                            @if (Auth::user()->roles->contains('name', 'admin') || Auth::user()->roles->contains('name', 'manager'))
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Back</a>
                            @else
                                <a href="{{ route('borrower.dashboard') }}" class="btn btn-outline-dark">Back</a>
                            @endif

                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    <!-- /.card -->
@endsection
