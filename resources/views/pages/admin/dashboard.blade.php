@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- Adding distance from the top navigation bar --}}
            </div>
        </div>
    </section>

    @if (Auth::user()->account_type != 'admin')
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="card">
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
                                            <span class="info-box-icon bg-info elevation-1"><i
                                                    class="fas fa-tag"></i></span>

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
    @else
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="card">
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
                                    <h3>Welcome to Zaiko Admin</h3>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info elevation-1"><i
                                                    class="fas fa-tag"></i></span>

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

                                    {{-- <!-- fix for small devices only -->
                                    <div class="clearfix hidden-md-up"></div> --}}

                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-success elevation-1"><i
                                                    class="fas fa-arrow-alt-circle-right"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Items Circulating</span>
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
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="card p-5">
                            <div class="info-box mb-3 bg-warning">
                                <span class="info-box-icon"><i class="fas fa-box"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Inventory</span>
                                    <span class="info-box-number">5,200</span>
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
    @endif
@endsection
