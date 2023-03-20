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
                        <th style="width:10%" class="text-wrap">Unit Number</th>
                        <th style="width:20%" class="text-wrap">Item Name</th>
                        <th style="width:45%" class="text-wrap">Item Description</th>
                        <th style="width:25%" class="text-wrap text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(session('cart'))
                        @foreach(session('cart') as $serial_number => $item)
                        <tr data-id="{{ $serial_number }}">
                            <td class="text-wrap">{{ $item['unit_number'] }}</td>
                            <td class="text-wrap">{{ $item['item_name'] }}</td>
                            <td class="text-wrap">{{ $item['item_description'] }}</td>
                            <td class="text-center"><button class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Remove</button></td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" class="text-right">
                            <a href="" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                            <button class="btn btn-success"><i class="bi bi-check2"></i> Borrow Items</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection