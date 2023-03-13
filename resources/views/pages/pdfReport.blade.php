<!DOCTYPE html>
<html>

<head>
    <title>Inventory Report for {{ $location }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container text-center justify-content-center">
        <span style="font-weight: 800; font-size:18pt">UNIVERSITY OF SAN JOSE-RECOLETOS <br>
            Inventory Report
        </span>
        <p><strong>
                @if ($purpose == null)
                @else
                    ({{ $purpose }})
                @endif
            </strong></p>
    </div>
    <div class="container" style="font-size:14pt">
        <strong>DATE PREPARED:</strong> {{ now()->format('m-d-Y') }} <br>
        <strong>DEPARTMENT / OFFICE:</strong> {{ $department }} <br>
        <strong>SPECIFIC LOCATION:</strong> {{ $location }}
    </div>
    <div class="container text-left">
        <table class="table table-bordered" style="width:auto;border: 1px solid black;">
            <thead style="width:auto;border-bottom: 1px solid black;">
                <tr>
                    <th scope="col" style="width:auto;border-right: 1px solid black;">Serial #</th>
                    <th scope="col" style="width:auto;border-right: 1px solid black;">Description of Item</th>
                    <th scope="col" style="width:auto;border-right: 1px solid black;">QTY</th>
                    <th scope="col" style="width:auto;border-right: 1px solid black;">UNIT #</th>
                    <th scope="col" style="width:auto;border-right: 1px solid black;">Aquisition Date</th>
                    <th scope="col" style="width:auto;border-right: 1px solid black;">Status</th>
                    <th scope="col">Inventory Tag</th>
                </tr>
            </thead>
            @foreach ($items as $item)
                @if ($item->location == $location)
                    <tbody>
                            <tr>
                                <th style="width:auto;border-right: 1px solid black;">{{ $item->serial_number }}</th>
                                <td style="width:auto;border-right: 1px solid black;">{{ $item->item_description }}</td>
                                <td style="width:auto;border-right: 1px solid black;">{{ $item->quantity }}</td>
                                <td style="width:auto;border-right: 1px solid black;">{{ $item->unit_number }}</td>
                                <td style="width:auto;border-right: 1px solid black;">{{ $item->aquisition_date }}</td>
                                <td style="width:auto;border-right: 1px solid black;">{{ $item->status }}</td>
                                <td>{{ $item->inventory_tag }}</td>
                            </tr>
                        {{-- <tr class=" bg-blue">
                            <td>Hello</td>
                        </tr> --}}
                    </tbody>
                @endif
            @endforeach
        </table>
    </div>

</html>
