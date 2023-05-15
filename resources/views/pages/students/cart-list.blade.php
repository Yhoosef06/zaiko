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
                        <th style="width:10%" class="text-wrap">Item Category</th>
                        <th style="width:10%" class="text-wrap">Brand</th>
                        <th style="width:20%" class="text-wrap">Model</th>
                        <th style="width:45%" class="text-wrap">Item Description</th>
                        <th style="width:25%" class="text-wrap text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $cart)
                        
                            <tr>
                                <td class="text-wrap">{{ $cart['category'] }}</td>
                                <td class="text-wrap">{{ $cart['brand'] }}</td>
                                <td class="text-wrap">{{ $cart['model'] }}</td>
                                <td class="text-wrap">{{ $cart['item_description'] }}</td>
                                <td class="text-center">
                                    {{-- <button class="btn btn-danger btn-sm" id="cart_remove"><i class="bi bi-x-circle"></i> Remove</button> --}}
                                <a class="border-0 text-danger text-decoration-underline" onclick="return confirm('Are you sure you want to remove item?')" href="{{ route('remove.cart', $cart->id)}}">Delete</a>
                                </td>
                            </tr>

                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" class="text-right">
                            <a href="{{ route('student.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                            <a href="{{ route('order.cart') }}" class="btn btn-success"><i class="fa fa-arrow-right"></i> Borrow Items</a>
                           
                        </td>
                    </tr>
                </tfoot>
            </table>

@endsection
