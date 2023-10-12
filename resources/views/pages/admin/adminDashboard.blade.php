@extends('layouts.pages.yields')

@section('content')
    <div class="borrower-bg borrower-page-height">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    {{-- @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <H4><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</H4>
                        </div>
                    @elseif (session('danger'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</h4>
                        </div>
                    @endif --}}
                </div>
            </div>
        </section>
 
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card" style="background-color: rgba(255, 255, 255, 0.75);">
                            <div class="card-header">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                                    </div>
                                @elseif (session('danger'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                                    </div>
                                @endif
                                <div class="card-title">
                                    <h3>Welcome {{Auth::user()->first_name}}!</h3>
                                </div>
                            </div>
                            <div class="container pt-2">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-box"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Inventory</span>
                                                <span class="info-box-number">
                                                    {{ $totalItems }}
                                                </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-exclamation-circle"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Missing Items</span>
                                                <span class="info-box-number">{{ $totalMissingItems }}</span>
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
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-tags"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Borrowed Items</span>
                                                <span class="info-box-number">0</span>
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
                                                <span class="info-box-number">{{ $totalUsers }}</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="container">
                                        <div class="card">
                                            <div class="card-header bg-warning">
                                                <h3 class="card-title">
                                                    <strong>Notifications</strong>
                                                </h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body p-0" style="max-height:200px; overflow-y: auto;">
                                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                                    {{-- <li class="item">
                                                    <div class="product-img">
                                                        <img src="dist/img/default-150x150.png" alt="Product Image"
                                                            class="img-size-50">
                                                    </div>
                                                    <div class="product-info">
                                                        <a href="javascript:void(0)" class="product-title">Samsung TV
                                                            <span class="badge badge-warning float-right">$1800</span></a>
                                                        <span class="product-description">
                                                            Samsung 32" 1080p 60Hz LED Smart HDTV.
                                                        </span>
                                                    </div>
                                                </li> --}}
                                                    <li class="item">
                                                        <div class="container">
                                                            <div class="text-center">
                                                                No Messeages.
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.container-fluid -->
                        </div>
                    </div>
        </section>
    </div>

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
