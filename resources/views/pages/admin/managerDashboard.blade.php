@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                                </div>
                            @elseif (session('danger'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                                </div>
                            @endif
                            <div class="card-title">
                                <h3>Hello! {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                            </div>
                        </div>
                        <div class="container">
                            <div class="container fluid">
                                <div class="row mb-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tag"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Pending Registrants</span>
                                            <span class="info-box-number">
                                                10
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i
                                                class="fas fa-exclamation-circle"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Unreturned Items</span>
                                            <span class="info-box-number">41,410</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-danger elevation-1"><i
                                                class="fas fa-exclamation-circle"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Unreturned Items</span>
                                            <span class="info-box-number">41,410</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-warning elevation-1"><i
                                                class="fas fa-users"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Users</span>
                                            <span class="info-box-number">2,000</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title danger" id="loginModalLabel">Welcome!</h5>
                </div>
                <div class="modal-body">
                    <p class=" text-lg-center">
                        Before you begin please
                        @if (Auth::user()->password_updated == false)
                            <a href="{{ route('change_user_password', ['id_number' => Auth::user()->id_number]) }}">click
                                this
                                link</a>
                        @else
                            <a href="{{ route('setup_security_question', ['id_number' => Auth::user()->id_number]) }}">click
                                this
                                link</a>
                        @endif
                        to setup your security settings. Thank you!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var accountType = "{{ auth()->user()->account_type }}";
    
            if (accountType != 'admin') {
                if ("{{ auth()->user()->password_updated }}" == 0 || "{{ auth()->user()->security_question_id }}" == '' || "{{ auth()->user()->answer }}" == '') {
                    $('#loginModal').modal('show');
                }
            }
        });
    </script>
@endsection
