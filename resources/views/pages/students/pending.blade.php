@extends('layouts.pages.yields')


@section('content')
    <div class="borrower-bg borrower-page-height">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pendings</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card" style="background-color: rgba(255, 255, 255, 0.8);">
                <div class="card-body">
                    @if (count($orders) != 0)
                        @foreach($orders as $order)
                            @php
                                $fordepartment = $items->where('order_id',$order->id)->first();
                            @endphp
                            <div class="container h-100 py-5">
                                <div class="row d-flex justify-content-center align-items-center h-100">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-1 card-header">
                                            <h3 class="fw-normal mb-0 text-black">Transaction #{{$order->id}} - {{$fordepartment->item->room->department->department_name}}</h3>
                                        </div>
                                        @foreach($items as $item)
                                            @if($item->order_id == $order->id)
                                            <div class="card rounded-3 mb-1">
                                                <div class="card-body p-2">
                                                    <div class="row d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            @if ($item->item->item_image == null)
                                                            <div class="img-fluid rounded-3"
                                                                style="border: 1px solid #000; height: 150px; display: flex; justify-content: center; align-items: center;">
                                                                <p>No image found.</p>
                                                            </div>
                                                            @else
                                                                <img src="{{ asset('storage/' . $item->item->item_image) }}"
                                                                    alt="" srcset="" class="img-fluid rounded-3">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            <p class="lead fw-normal mb-2">{{ $item->item->brand->brand_name }}</p>
                                                            <p><span class="text-muted"> {{ $item->item->model->model_name }} </span></p>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            <p><span class="text-muted"> {{ $item->item->description }} </span></p>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">                          
                                                            <input id="form1" min="0" name="quantity" value="{{ $item->quantity }}" type="number"
                                                            class="form-control form-control-sm text-center" disabled />                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                        <div class="card">
                                            <form action="{{route('remove.transaction', $order->id)}}" method="GET" onsubmit="return showCancelTransaction(this)">
                                                @csrf
                                                <div class="card-body">
                                                <button type="submit" class="btn btn-warning btn-block btn-lg">Cancel this transaction.</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="container h-100 py-5">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="text-center">
                                    <p><span class="h3"> No pending transactions. </span></p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
       function showCancelTransaction(form) {
                Swal.fire({
                    title: "Do you want to cancel the transaction??",
                    showDenyButton: true,
                    // showCancelButton: true,
                    confirmButtonText: "Yes",
                    denyButtonText: `No`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        Swal.fire({
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1500,
                                title: "Successfully Cancelled!",
                                icon: "success"
                            }).then(() => {
                            form.submit();
                        });
                    } else if (result.isDenied) {
                    Swal.fire("Action canceled", "", "info");
                }
                });
        
                // Prevent the default form submission
                return false;
            }
    </script>
@endsection
