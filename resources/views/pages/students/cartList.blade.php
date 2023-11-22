@extends('layouts.pages.yields')

@section('content-header')
    
@endsection

@section('content')
<div class="borrower-bg borrower-page-height">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Carts By Department</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card" style="background-color: rgba(255, 255, 255, 0.8);">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="cart" class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-success" style="background-color: rgba(0, 150, 0, 0.9) !important;">
                                <th style="width:10%" class="text-wrap">Order ID</th>
                                <th style="width:80%" class="text-wrap">Department</th>
                                <th style="width:10%" class="text-wrap text-center">Actions</th>
                            </tr>
                        </thead>
                        @if($orders != null)
                        <tbody>
                            @foreach($orders as $order)
                                <tr style="background-color: rgba(255, 255, 255, 0.8);">
                                    <td class="text-wrap text-center">{{ $order->id }}</td>
                                    <td class="text-wrap">{{ $order->orderItemTemp->first()->item->room->department->department_name }}</td>
                                    <form action="{{ route('browse.cart-id',$order->id) }}">
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                        @endif
                        <tfoot>
                            @if($orders != null)
                                <tr>
                                    <td colspan="10" class="text-left">
                                        <a href="{{ route('browse.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="12" class="text-center">
                                        <a href="{{ route('browse.items') }}" class="btn btn-danger"><i class="bi bi-cart-x"></i> No items in cart</a>
                                    </td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection