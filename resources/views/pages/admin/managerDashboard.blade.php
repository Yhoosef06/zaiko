@extends('layouts.pages.yields')

@section('content')
    <div class="borrower-bg borrower-page-height">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
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
                                    <h3>Hello {{ Auth::user()->first_name }}!</h3>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row pt-2">
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-users"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Pending Registrants</span>
                                                <span class="info-box-number">
                                                    {{ $totalPendingRegistrants }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fa fa-arrow-alt-circle-up"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Borrowed Items </span>
                                                <span class="info-box-number">0</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-tag"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Pending Borrow Items </span>
                                                <span class="info-box-number">0</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-box"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Inventory</span>
                                                <span class="info-box-number">{{ $totalItems }}</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        <h3 class="card-title">
                                            <strong>Notifications</strong>
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0" style="max-height:100px; overflow-y: auto;">
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
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                if ("{{ auth()->user()->password_updated }}" == 0 ||
                    "{{ auth()->user()->security_question_id }}" ==
                    '' || "{{ auth()->user()->answer }}" == '') {
                    $('#loginModal').modal('show');
                }
            }
        });
    </script>
@endsection
