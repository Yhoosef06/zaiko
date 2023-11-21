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
                                                    class="fas fa-exclamation-triangle"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Overdue</span>
                                                <span class="info-box-number">
                                                    {{ $overdue }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fa fa-arrow-alt-circle-up"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Outgoing Items </span>
                                                <span class="info-box-number">{{$countBorrow}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-warning elevation-1"><i
                                                    class="fas fa-tag"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Pending </span>
                                                <span class="info-box-number">{{ $pendings }}</span>
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
                                            <li class="item">
                                                <div class="container">
                                                    <div class="text-center">
                                                    @php
                                                        if( $pendings > 0 ){
                                                            echo '<h5>There are <span class="h4" style="color: red;">' . $pendings . '</span> pending items waiting for approval.</h5>';
                                                            if( $overdue > 0 ){
                                                                echo '<h5>There are <span class="h4" style="color: red;">' . $overdue . '</span> overdue items that need to be returned.</h5>';
                                                                
                                                            }

                                                        }else{
                                                            echo 'No Messeages.';
                                                        }
                                                    @endphp
                                                     
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
@endsection
