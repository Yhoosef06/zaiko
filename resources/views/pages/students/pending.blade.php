@extends('layouts.pages.yields')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Items in Cart</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
            <table id="cart" class="table">
              
                <thead>
                    <tr>
                        <th style="width:10%" class="text-wrap">Order ID</th>
                        <th style="width:10%" class="text-wrap">Date Submitted</th>
                        <th style="width:10%" class="text-wrap text-center">Actions</th>
                    </tr>
                </thead>
                @if($pendingOrder != null)
                <tbody>
                   
                        @foreach($pendingOrder as $order)
                            
                                <tr>
                                
                                    <td class="text-wrap">{{ $order->id }}</td>
                                    <td class="text-wrap">{{ date('F j, Y',strToTime($order->date_submitted)) }}</td>
                                    <td class="text-center">    
                                        <a href="#" class="link-secondary">
                                            <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#itemModal">
                                             <i class="bi bi-eye"></i>
                                            </button>   
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade bd-example-modal-xl" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-dark">
                                            <h5 class="modal-title" id="itemModalLabel"><b>PENDING ORDER - ORDER ID {{$order->id}}</b></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body text-dark">
                                                <div class="container">
                                                    <div class="container-fluid px-5 text-justify">
                                                        <div class="border border-success rounded px-5 py-5">
                                                            @php
                                                                $items = $order->orderItemTemp;
                                                                // dd($items);
                                                            @endphp
                                                            @foreach($items as $item)
                                                                <div class="mb-5 border border-secondary">
                                                                    <div class="row text-lg mt-2 mb-2">
                                                                        <div class="col ml-4">
                                                                            <strong>Brand:</strong> {{ $item->item->brand->brand_name }} <br>
                                                                            <strong>Model:</strong> {{ $item->item->model->model_name }} <br>
                                                                            
                                                                        </div>
                                                                        <div class="col mr-4">
                                                                            <strong>Description:</strong> {{ $item->item->description }} <br>
                                                                            <strong>Quantity:</strong> {{$item->quantity}} <br>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            @endforeach
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                            
                                            <script>
                                                $(document).ready(function() {
                                                $("#modal-link").click(function(e) {
                                                    e.preventDefault();
                                                    $("#itemModal").modal("show");
                                                });
                                                });
                                            </script>
                                            
                                        </div>
                                    </div>
                                </div>


                        @endforeach
                   

                </tbody>       
                @endif
                <tfoot>
                    @if($pendingOrder != null)
                    {{-- <tr>
                        <td colspan="10" class="text-right">
                            <a href="{{ route('student.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                            <a href="{{ route('order.cart') }}" class="btn btn-success" data-toggle="modal" data-target="#itemModal"><i class="fa fa-arrow-right"></i> Borrow Items</a>
                        </td>
                    </tr> --}}
                    @else
                    <tr>
                        <td colspan="12" class="text-center">
                            <a href="{{ route('student.items') }}" class="btn btn-danger"><i class="bi bi-cart-x"></i> No PENDING Orders</a>
                            
                        </td>
                    </tr>
                    @endif
                </tfoot>
                
            </table>
            <!-- Modal -->
            <div class="modal fade bd-example-modal-xl" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-dark">
                        <h5 class="modal-title" id="itemModalLabel"><b>ORDER HISTORY</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body text-dark">
                            <div class="container">
                                <div class="container-fluid px-5 text-justify">
                                    <div class="border border-success rounded px-5 py-5">

                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                        <script>
                            $(document).ready(function() {
                              $("#modal-link").click(function(e) {
                                e.preventDefault();
                                $("#itemModal").modal("show");
                              });
                            });
                        </script>
                        
                    </div>
                </div>
            </div>

@endsection
