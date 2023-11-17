@extends('layouts.pages.yields')


@section('content')
<div class="borrower-bg borrower-page-height">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">History</h1>
                    </div>
                </div>
            </div>
        </div>
<div class="container">
        <div class="card" style="background-color: rgba(255, 255, 255, 0.8);">
            <div class="card-body">
                <table id="cart" class="table table-bordered table-striped">
            
              
                <thead>
                    <tr class="bg-success" style="background-color: rgba(0, 150, 0, 0.9) !important;">
                        <th style="width:10%" class="text-wrap text-center">Transaction ID</th>
                        <th style="width:10%" class="text-wrap text-center">Date Borrowed</th>
                        <th style="width:10%" class="text-wrap text-center">Date Returned</th>
                        <th style="width:10%" class="text-wrap text-center">Actions</th>
                    </tr>
                </thead>
                @if(count($orderHistory) != 0)
                
                   
                        @foreach($orderHistory as $order)
                        <tbody>    
                                <tr style="background-color: rgba(255, 255, 255, 0.8);">
                                
                                    <td class="text-wrap text-center">{{ $order->id }}</td>
                                    <td class="text-wrap text-center">{{ date('F j, Y',strToTime($order->date_submitted)) }}</td>
                                    <td class="text-wrap text-center">{{ date('F j, Y',strToTime($order->date_returned)) }}</td>
                                    <td class="text-center">    
                                        <a href="#" class="link-secondary">
                                            <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#itemModal">
                                             <i class="bi bi-eye"></i>
                                            </button>   
                                        </a>
                                    </td>
                                </tr>
                            </tbody>       
                           
                        @endforeach
                    </table>
                        <div class="modal fade bd-example-modal-xl" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-dark">
                                    <h5 class="modal-title" id="itemModalLabel"><b>ORDER HISTORY - ORDER ID {{$order->id}}</b></h5>
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
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="bg-success" style="background-color: rgba(0, 150, 0, 0.9) !important;">
                                                                <th style="width:10%" class="text-wrap">Brand</th>
                                                                <th style="width:10%" class="text-wrap">Model</th>
                                                                <th style="width:10%" class="text-wrap">Description</th>
                                                                <th style="width:10%" class="text-wrap text-center">Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($items as $item)
                                                                <tr style="background-color: rgba(255, 255, 255, 0.8);">
                                                                    <td class="text-wrap">{{ $item->item->brand->brand_name }}</td>
                                                                    <td class="text-wrap">{{ $item->item->model->model_name }}</td>
                                                                    <td class="text-wrap">{{ $item->item->description }}</td>
                                                                    <td class="text-wrap text-center">{{ $item->quantity }}</td>
                                                                </tr>                
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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
                        @else
                        <tfoot>
                            <tr>
                                <td colspan="12" class="text-center">
                                    <a href="{{ route('browse.items') }}" class="btn btn-danger"><i class="bi bi-cart-x"></i> No BORROWING History</a>
                                    
                                </td>
                            </tr>
                            @endif
                        </tfoot>
                
                </table>
            </div>
</div>
@endsection
