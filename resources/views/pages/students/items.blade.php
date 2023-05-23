@extends('layouts.pages.yields')


@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Borrowing</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Items available to borrow</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="m-4">
            <ul class="nav nav-tabs" id="myTab">
                @foreach ($categories as $category)
                    <li class="nav-item">
                        <a href="#pc" class="nav-link active" data-bs-toggle="tab">{{ $category->category_name }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pc">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            @foreach ($items as $item)
                                @if ($item->item_category == 'PCs')
                                    @if ($item->borrowed == 'no')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-info bg-gradient">
                                                <div class="inner">
                                                    <h3>{{ $item->unit_number }}</h3>

                                                    <p>{{ Str::limit($item->item_description, 30, '...') }}</p>
                                                </div>
                                                <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                    class="small-box-footer">More info <i
                                                        class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="laptop">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            @foreach ($items as $item)
                                @if ($item->item_category == 'Monitor')
                                    @if ($item->borrowed == 'no')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-success bg-gradient">
                                                <div class="inner">
                                                    <h3>{{ $item->unit_number }}</h3>

                                                    <p>{{ Str::limit($item->item_description, 30, '...') }}</p>
                                                </div>
                                                <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                    class="small-box-footer">More info <i
                                                        class="fas fa-arrow-circle-right"></i></a>

                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="phone">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            @foreach ($items as $item)
                                @if ($item->item_name == 'Mouse')
                                    @if ($item->borrowed == 'no')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-danger bg-gradient">
                                                <div class="inner">
                                                    <h3>{{ $item->unit_number }}</h3>

                                                    <p>{{ Str::limit($item->item_description, 30, '...') }}</p>
                                                </div>
                                                <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                    class="small-box-footer">More info <i
                                                        class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


{{-- <li class="nav-item">
                        <a href="#pc" class="nav-link active" data-bs-toggle="tab">PC</a>
                    </li>
                    <li class="nav-item">
                        <a href="#laptop" class="nav-link" data-bs-toggle="tab">Laptop</a>
                    </li>
                    <li class="nav-item">
                        <a href="#phone" class="nav-link" data-bs-toggle="tab">Phone</a>
                    </li> --}}