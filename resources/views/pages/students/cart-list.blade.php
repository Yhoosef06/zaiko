@extends('layouts.students.yields')


@section('content')
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Items in Cart</h1>
                        </div>
                    </div>
                </div>
            </div>
            <table id="cart" class="table">

                <thead>
                    <tr>
                        <th style="width:10%" class="text-wrap">Serial Number</th>
                        <th style="width:20%" class="text-wrap">Item Name</th>
                        <th style="width:45%" class="text-wrap">Item Description</th>
                        <th style="width:25%" class="text-wrap text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $cart)
                        
                            <tr>
                                <td class="text-wrap">{{ $cart['serial_number'] }}</td>
                                <td class="text-wrap">{{ $cart['item_name'] }}</td>
                                <td class="text-wrap">{{ $cart['item_description'] }}</td>
                                <td class="text-center">
                                    {{-- <button class="btn btn-danger btn-sm" id="cart_remove"><i class="bi bi-x-circle"></i> Remove</button> --}}
                                <a class="border-0 text-danger text-decoration-underline" onclick="return confirm('Are you sure you want to remove item?')" href="{{ route('remove.cart', $cart->serial_number)}}">Delete</a>
                                </td>
                            </tr>

                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" class="text-right">
                            <a href="{{ route('student.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                            <button class="btn btn-success"><i class="bi bi-check2"></i> Borrow Items</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection
