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
                                        @if($item->borrowed == 'no')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-info bg-gradient">
                                                <div class="inner">
                                                    <h3>{{$item->unit_number}}</h3>
                    
                                                    <p>{{Str::limit($item->item_description, 30, '...')}}</p>
                                                </div>
                                                <div class="small-box-footer d-grid gap-2">
                                                    <button type="button" class="btn btn-link text-dark" data-toggle="modal" data-target="#itemModal{{$item->serial_number}}">
                                                        More info <i class="fas fa-arrow-circle-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="itemModal{{$item->serial_number}}" tabindex="-1" role="dialog" aria-labelledby="itemModal{{$item->serial_number}}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="itemModal{{$item->serial_number}}Label">{{$item->item_name}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div class="row text-lg">
                                                        <div class="col">
                                                            <strong>Item Name:</strong> {{ $item->item_name }} <br>
                                                            <strong>Unit Number:</strong> {{ $item->unit_number }} <br>
                                                            <strong>Location:</strong> {{ $item->location }} <br>
                                                        </div>
                                        
                                                        <div class="col">
                                                            <strong>Item Description:</strong> {{ $item->item_description }} <br>
                                                            <strong>Status:</strong> {{ $item->status }}
                                                        </div>
                                                    </div>
                                                    
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('add.cart',$item->serial_number) }}" method="POST" onsubmit="return confirm('Are you sure you want to add this item to your cart?');">
                                                            @csrf
                                                            <input type="submit" class="btn btn-outline-dark" value="Add to cart">
                                                        </form>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                </div>
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
                                    @if($item->item_name == 'Monitor')
                                        @if($item->borrowed == 'no')
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
                                    @if($item->item_name == 'Mouse')
                                        @if($item->borrowed == 'no')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-danger bg-gradient">
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
                                    @endif
                                @endforeach 
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>


@endsection
