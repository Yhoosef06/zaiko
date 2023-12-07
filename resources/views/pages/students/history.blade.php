@extends('layouts.pages.yields')


@section('content')
    <div class="borrower-bg borrower-page-height">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Items Borrowed</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card" style="background-color: rgba(255, 255, 255, 0.8);">
                <div class="card-body">
                    @if (count($items) != 0)
                        @foreach($releasedOrders as $order)
                            @php
                                $foritem = $orderItems->where('order_id',$order->id)->first();
                                if($foritem != null){
                                    $itemid = $foritem->item_id;
                                    $fordepartment = $items->where('id',$itemid)->first();
                                }
                            @endphp
                            @if($foritem != null)
                                <div class="container h-100 py-5">
                                    <div class="row d-flex justify-content-center align-items-center h-100">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center mb-1 card-header">
                                                <h3 class="fw-normal mb-0 text-black">Transaction #{{$order->id}} - {{$fordepartment->room->department->department_name}}</h3>
                                            </div>
                                            @foreach($orderItems as $orderItem)
                                            @if($orderItem->order_id == $order->id)
                                                @foreach($items as $item)
                                                    @if($item->id == $orderItem->item_id)
                                                    <div class="card  rounded-3 mb-1">
                                                        <div class="card-body p-2">
                                                            <div class="row d-flex justify-content-between align-items-center">
                                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                                    @if ($item->item_image == null)
                                                                    <div class="img-fluid rounded-3"
                                                                        style="border: 1px solid #000; height: 150px; display: flex; justify-content: center; align-items: center;">
                                                                        <p>No image found.</p>
                                                                    </div>
                                                                    @else
                                                                        <img src="{{ asset('storage/' . $item->item_image) }}"
                                                                            alt="" srcset="" class="img-fluid rounded-3">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                                    <p class="lead fw-normal mb-2">{{ $item->brand->brand_name }}</p>
                                                                    <p><span class="text-muted"> {{ $item->model->model_name }} </span></p>
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                                    <p><span class="text-muted"> {{ $item->description }} </span></p>
                                                                    <p><span>Serial:</span><span class="text-muted"> {{ $item->serial_number }} </span></p>
                                                                </div>
                                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                                    <p><span class="h4 text-danger">{{ strtoupper($orderItem->status) }}</span></p>    
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">                 
                                                                    <input id="form1" min="0" name="quantity" value="{{ $orderItem->order_quantity }}" type="number"
                                                                    class="form-control form-control-sm text-center" disabled />                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                            @endif
                            </div>
                        @endforeach
                    @else
                        <div class="container h-100 py-5">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="text-center">
                                    <p><span class="h3"> No history. </span></p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
