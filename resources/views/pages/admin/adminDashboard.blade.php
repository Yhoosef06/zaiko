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
                                                    class="fas fa-toggle-off"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Inactive Users</span>
                                                <span class="info-box-number">{{ $inactiveUsers }}</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-toggle-on"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Active Users</span>
                                                <span class="info-box-number">{{$activeUsers}}</span>
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

                                    {{-- <div class="container">
                                        <div class="card">
                                            <div class="card-header bg-warning">
                                                <h3 class="card-title">
                                                    <strong>Notifications</strong>
                                                </h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body p-0" style="max-height:200px; overflow-y: auto;">
                                                <ul class="products-list product-list-in-card pl-2 pr-2">
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
                                    </div> --}}
                                </div>
                            </div><!-- /.container-fluid -->
                        </div>
                    </div>
        </section>
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
