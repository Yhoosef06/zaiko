@extends('layouts.pages.yields')

@section('content')
    <div class="borrower-bg borrower-page-height">
        <div class="content-header">
            <div class="container-fluid">
                {{-- <div class="row mb-2">
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
                    
                </div><!-- /.row --> --}}
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content ">
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
                                    <h3>Hello {{Auth::user()->first_name}}!</h3>
                                </div>
                            </div>
                            <div class="container pt-2">
                                <div class="row">
                                    {{-- <div class="col-12 col-sm-12 col-md-4">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="bi bi-cart"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Items in Cart</span>
                                                <span class="info-box-number">
                                                 
                                                </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div> --}}
                                    <!-- /.col -->
                                    {{-- <div class="col-12 col-sm-6 col-md-4">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-exclamation-circle"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Missing Items</span>
                                               
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div> --}}
                                    <!-- /.col -->

                                    {{-- <!-- fix for small devices only -->
                                    <div class="clearfix hidden-md-up"></div> --}}

                                    {{-- <div class="col-12 col-sm-6 col-md-4">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-tags"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Borrowing History</span>
                                                <span class="info-box-number">0</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div> --}}
                                    <div class="container">
                                        <div class="card">
                                            <!-- /.card-header -->
                                            <div class="card-body p-0" style="max-height:50%; overflow-y: auto;">
                                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                                    <li class="item">
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
                                            <!-- {{-- <li class="item">
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
                                        </li> --}} -->
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
                                                  
                                                  
                                                        <div class="container mb-2">
                                                            <div class="text-center">
                                                                <a href="{{ route('student.items') }}" class="btn btn-lg btn-warning">Start Borrowing</a>
                                                            </div>
                                                        </div>
                                                    
                                                
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        {{-- <div class="card">
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
                                        </div> --}}
                                    </div>
                                </div>
                            </div><!-- /.container-fluid -->
                        </div>
            </div>

        </section>
    </div>
@endsection
