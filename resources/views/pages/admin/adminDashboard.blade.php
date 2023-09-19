@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <H4><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</H4>
                    </div>
                @elseif (session('danger'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</h4>
                    </div>
                @endif
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
                                <h3>Welcome Admin!</h3>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Inventory</span>
                                            <span class="info-box-number">
                                                {{ $totalQuantity }}
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
                                            <span class="info-box-text">Missing</span>
                                            <span class="info-box-number">{{$totalMissingItems}}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->

                                {{-- <!-- fix for small devices only -->
                                    <div class="clearfix hidden-md-up"></div> --}}

                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-success elevation-1"><i
                                                class="fas fa-arrow-alt-circle-right"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Items</span>
                                            <span class="info-box-number">760</span>
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
                                            <span class="info-box-text">Pending Users</span>
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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card p-5">
                        <div class="info-box mb-3 bg-warning">
                            <span class="info-box-icon"><i class="fas fa-box"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Inventory</span>
                                <span class="info-box-number">
                                    {{ $totalQuantity }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>

                        <div class="info-box mb-3  bg-gradient-info">
                            <span class="info-box-icon"><i class="fas fa-info"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Data</span>
                                <span class="info-box-number">114,381</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
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
                        Before you begin using Zaiko please <a
                            href="{{ route('change_user_password', ['id_number' => Auth::user()->id_number]) }}">click this
                            link</a> to setup your security
                        settings. Thank you!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var accountType = "{{ auth()->user()->account_type }}";
            var userQuestion = "{{ auth()->user()->security_question_id }}";

            if (accountType !== 'admin') {
                if ((accountType === 'faculty' || accountType === 'reader' || accountType === 'student') &&
                    userQuestion === '' || null) {
                    $('#loginModal').modal('show');
                }
            }
        });
    </script>
@endsection
