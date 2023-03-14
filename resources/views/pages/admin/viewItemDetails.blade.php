@extends('pages.admin.home')

@section('content')
    <div class="container shadow-lg">
        <div class="container p-3">
            <div class="row text-lg">
                <div class="col">
                    <strong>Serial Number:</strong> {{ $item->serial_number }} <br>
                    <strong>Item Description:</strong> {{ $item->item_description }} <br>
                    <strong>Quantity:</strong> {{ $item->quantity }} <br>
                    <strong>Aquisition Date:</strong> {{ $item->aquisition_date }} <br>
                    <strong>Unit Number:</strong> {{ $item->unit_number }} <br>
                </div>

                <div class="col">
                    <strong>Location:</strong> {{ $item->location }} <br>
                    <strong>Inventory Tag:</strong> {{ $item->inventory_tag }} <br>
                    <strong>Borrowed?:</strong> {{ $item->borrowed }} <br>
                    <strong>Status:</strong> {{ $item->status }}
                </div>
            </div>
            <hr>
            <a href="{{ route('view_items') }}" class="btn btn-outline-dark">Back</a>
        </div>
    </div>
@endsection
