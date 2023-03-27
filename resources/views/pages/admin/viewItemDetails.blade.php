@extends('layouts.pages.yields')

@section('content')
    <div class="container shadow-lg">
        <div class="container p-3">
            <div class="row text-lg">
                <div class="col">
                    <strong>Serial Number:</strong> {{ $item->serial_number }} <br>
                    <strong>Item Name:</strong> {{ $item->item_name }} <br>
                    <strong>Quantity:</strong> {{ $item->quantity }} <br>
                    <strong>Aquisition Date:</strong> {{ $item->aquisition_date }} <br>
                    <strong>Unit Number:</strong> {{ $item->unit_number }} <br>
                </div>

                <div class="col">
                    <strong>Location:</strong> {{ $item->location }} <br>
                    <strong>Item Description:</strong> {{ $item->item_description }} <br>
                    <strong>Inventory Tag:</strong> {{ $item->inventory_tag }} <br>
                    <strong>Borrowed?:</strong> {{ $item->borrowed }} <br>
                    <strong>Status:</strong> {{ $item->status }}
                </div>
            </div>

            <div class="card text-center">
                <div class="card-header">
                    <h5>{{ $item->serial_number }} QR Code</h5>
                </div>
                <div class="card-body">
                    <img src="data:image/png;base64, {!! base64_encode(
                        QrCode::format('png')->size(150)->generate($item->serial_number),
                    ) !!} " alt="" srcset=""><br>
                    <a href="data:image/png;base64, {!! base64_encode(
                        QrCode::format('png')->size(300)->generate($item->serial_number),
                    ) !!} "
                        download="{{ 'Item_' . $item->serial_number . '_QRCode' }}">Download</a>
                </div>
            </div>
            <hr>
            <a href="{{ route('view_items') }}" class="btn btn-outline-dark">Back</a>
        </div>
    </div>
@endsection
