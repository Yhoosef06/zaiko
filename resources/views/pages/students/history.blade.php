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
                        <th style="width:10%" class="text-wrap">Category</th>
                        <th style="width:10%" class="text-wrap">Brand</th>
                        <th style="width:10%" class="text-wrap">Model</th>
                        <th style="width:25%" class="text-wrap">Description</th>
                        <th style="width:20%" class="text-wrap text-center">Quantity</th>
                        <th style="width:10%" class="text-wrap text-center">Actions</th>
                    </tr>
                </thead>
                @if($cartItems != null)
                <tbody>
                   
                        @foreach($cartItems as $cart)
                            
                                <tr>
                                
                                    <td class="text-wrap">{{ $cart->item->category->category_name }}</td>
                                    <td class="text-wrap">{{ $cart->item->brand }}</td>
                                    <td class="text-wrap">{{ $cart->item->model }}</td>
                                    <td class="text-wrap">{{ $cart->item->description }}</td>
                                    {{-- <td class="text-wrap text-center">
                                        <i class="fa fa-minus" onclick="updateQuantity('{{ $cart->id }}', -1)"></i>
                                        <input type="text" name="" id="" value="{{ $cart->quantity }}">
                                        <i class="fa fa-plus" onclick="updateQuantity('{{ $cart->id }}', 1)"></i>
                                    </td> --}}

                                    <td class="text-center">
                                        @php 
                                            $catItem = $items->where('category_id',$cart->item->category->id)->where('brand',$cart->item->brand)->where('model',$cart->item->model)->sortByDesc('id');
                                            // dd($catItem);
                                            // $groupedItems = $catItem->groupBy(function ($item) {
                                            //     return $item->brand . '_' . $item->model;
                                            // });
                                            // dd($catItem);
                                            // dd($groupedItems);

                                            // $quantity = 0;

                                            // foreach($groupedItems as $key =>$collection ){
                                            //     $quantity += count($collection);
                                            // }
                                            // dd($quantity);
                                            
                                        @endphp
                                        <button class="btn btn-default btn-sm minus-btn">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input id="quantity-input" type="number" value="{{ $cart->quantity }}" min="0"
                                            max="{{ count($catItem) }}">
                                        <button class="btn btn-default btn-sm plus-btn">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                        {{-- <button class="btn btn-danger btn-sm" id="cart_remove"><i class="bi bi-x-circle"></i> Remove</button> --}}
                                    <td class="text-center">
                                        <a class="border-0 text-danger text-decoration-underline" onclick="return confirm('Are you sure you want to remove item?')" href="{{ route('remove.cart', $cart->id)}}">Delete</a>
                                    </td>
                                </tr>


                        @endforeach
                   

                </tbody>       
                @endif
                <tfoot>
                    @if($cartItems != null)
                    <tr>
                        <td colspan="10" class="text-right">
                            <a href="{{ route('student.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                            <a href="{{ route('order.cart') }}" class="btn btn-success" data-toggle="modal" data-target="#itemModal"><i class="fa fa-arrow-right"></i> Borrow Items</a>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="12" class="text-center">
                            <a href="{{ route('student.items') }}" class="btn btn-danger"><i class="bi bi-cart-x"></i> No items in cart</a>
                            
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
                            {{-- <form action="{{ route('order.cart') }}" method="POST" onsubmit="return confirm('Are you sure you want to borrow items in the cart??');">
                                @csrf
                                <input type="submit" class="btn btn-outline-dark" value="Add to cart" id="addToCartButton" disabled>
                            </form> --}}
                            {{-- <a href="{{ route('order.cart') }}" onclick="return confirm('Are you sure you want to borrow items in cart?')" class="btn btn-outline-dark" id="addToCartButton" disabled><i class="fa fa-arrow-right" ></i> Borrow Items</a> --}}
                            <button type="button" class="btn btn-outline-dark" id="addToCartButton" disabled>
                                <a href="{{ route('order.cart') }}" onclick="return confirm('Are you sure you want to borrow items in cart?')"><i class="fa fa-arrow-right"></i> Borrow Items</a>
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                        <script>
                            const agreementCheckbox = document.getElementById('agreementCheckbox');
                            const addToCartButton = document.getElementById('addToCartButton');
                        
                            agreementCheckbox.addEventListener('change', function() {
                                addToCartButton.disabled = !agreementCheckbox.checked;
                            });
                        </script>
                        
                    </div>
                </div>
            </div>

@endsection
