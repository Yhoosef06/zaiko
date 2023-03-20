@extends('layouts.students.yields')

@section('content')

{{-- @auth --}}
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Borrowing</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Items available to borrow</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="m-4">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="nav-item">
                        <a href="#pc" class="nav-link active" data-bs-toggle="tab">PC</a>
                    </li>
                    <li class="nav-item">
                        <a href="#laptop" class="nav-link" data-bs-toggle="tab">Laptop</a>
                    </li>
                    <li class="nav-item">
                        <a href="#phone" class="nav-link" data-bs-toggle="tab">Phone</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pc">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                @foreach ($items as $item)
                                    @if($item->item_name == 'PC')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-info bg-gradient">
                                                <div class="inner">
                                                    <h3>{{$item->unit_number}}</h3>
                    
                                                    <p>{{Str::limit($item->item_description, 30, '...')}}</p>
                                                </div>
                                                {{-- <div class="icon">
                                                <i class="ion ion-bag"></i>
                                            </div> --}}
                                            <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    
                                    @endif
                                @endforeach 
                            </div>
                            <!-- /.row -->
                            <!-- Main row -->
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="laptop">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                @foreach ($items as $item)
                                    @if($item->item_name == 'Monitor')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-success bg-gradient">
                                                <div class="inner">
                                                    <h3>{{$item->unit_number}}</h3>
                    
                                                    <p>{{Str::limit($item->item_description, 30, '...')}}</p>
                                                </div>
                                                <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                    class="small-box-footer">More info <i
                                                    class="fas fa-arrow-circle-right"></i></a>

                                            </div>
                                        </div>
                                    
                                    @endif
                                @endforeach 
                            </div>
                            <!-- /.row -->
                            <!-- Main row -->
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="phone">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                @foreach ($items as $item)
                                    @if($item->item_name == 'Mouse')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-danger bg-gradient">
                                                <div class="inner">
                                                    <h3>{{$item->unit_number}}</h3>
                    
                                                    <p>{{Str::limit($item->item_description, 30, '...')}}</p>
                                                </div>
                                                {{-- <div class="icon">
                                                <i class="ion ion-bag"></i>
                                            </div> --}}
                                            <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                class="small-box-footer">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    
                                    @endif
                                @endforeach 
                            </div>
                            <!-- /.row -->
                            <!-- Main row -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
    </div>
</div>
{{-- @endauth --}}



@endsection


{{-- <div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>1</h3>

                <p>Borrowed Items</p>
            </div>
            {{-- <div class="icon">
            <i class="ion ion-bag"></i>
        </div> --}}
            {{-- <a href="#" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a> --}}
        {{-- </div>
    </div> --}}
    {{-- <!-- ./col -->
    <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
        <div class="inner">
            <h3>53<sup style="font-size: 20px">%</sup></h3>

            <p>Bounce Rate</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div> --}}
    <!-- ./col -->
    {{-- <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>2</h3>

                <p>Notifications</p>
            </div>
            <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
            <a href="#" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div> --}}
    {{-- <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>2</h3>

                <p>Notifications</p>
            </div>
            <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
            <a href="#" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div> --}}
    <!-- ./col -->
{{-- </div> --}}

<!-- /.row -->
<!-- Main row -->
{{-- <div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">
        
        
    </section>
    
</div> --}}