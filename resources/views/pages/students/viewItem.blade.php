@extends('layouts.pages.yields')

@section('content')
    <div class="container shadow-lg">
        <div class="container p-3">
            <div class="row text-lg">
                <div class="col">
                    <strong>Serial Number1:</strong> {{ $item->serial_number }} <br>
                    <strong>Item Name:</strong> {{ $item->item_name }} <br>
                    <strong>Unit Number:</strong> {{ $item->unit_number }} <br>
                </div>

                <div class="col">
                    <strong>Location:</strong> {{ $item->location }} <br>
                    <strong>Item Description:</strong> {{ $item->item_description }} <br>
                    <strong>Status:</strong> {{ $item->status }}
                    <div>
                        {!! QrCode::size(200)->generate($item->id) !!}
                    </div>
                </div>
            </div>
            <hr>
            <form action="{{ route('add.cart',$item->serial_number) }}" method="POST">
                @csrf

                <input type="submit" class="btn btn-outline-dark" value="Add to cart">
            </form>
            <a href="{{ route('student.items') }}" class="btn btn-outline-dark">Back</a>
            {{-- <a href="{{ route('student.cart', $item->serial_number) }}" class="btn btn-outline-dark">Add to borrow cart</a> --}}

        </div>
    </div>
@endsection