<!DOCTYPE html>
<html>

<head>
    <title>Inventory Report @foreach ($rooms as $room)
            @if ($room->id == $location)
                {{ $room->room_name }}
            @endif
        @endforeach
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<style>
    table {
        margin-bottom: 20px
    }

    table,
    th,
    td {
        border: 1px solid;
        border-collapse: collapse;
        text-align: center;
    }

    #intro_details {
        margin-bottom: 10px;
        font-size: 12pt
    }

    #purpose {
        font-size: 12px;
        margin-bottom: 20px;
    }

    .signee {
        text-decoration: underline;
        margin-top: 50px;
    }

    .column {
        float: left;
        width: 50%;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<body>
    <div class="container" style="font-weight: 800; font-size:18pt; text-align:center">
        UNIVERSITY OF SAN JOSE-RECOLETOS <br>
        Inventory Report
        <div class="container" id="purpose">
            @if ($purpose == null)
            @else
                ({{ $purpose }})
            @endif
        </div>
    </div>
    <div class="container" id="intro_details">
        <strong>DATE PREPARED:</strong> {{ now()->format('F j, Y') }} <br>
        <strong>DEPARTMENT / OFFICE:</strong> {{ $department }} <br>
        <strong>SPECIFIC LOCATION:</strong>
        @foreach ($rooms as $room)
            @if ($room->id == $location)
                {{ $room->room_name }}
            @endif
        @endforeach
    </div>
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Serial #</th>
                    <th scope="col">Description of Item</th>
                    <th scope="col">QTY</th>
                    <th scope="col">UNIT #</th>
                    <th scope="col">Aquisition Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Inventory Tag</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items->groupBy('unit_number') as $item)
                    @foreach ($item as $index => $unit)
                        @if ($unit->location == $location)
                            {{-- @if ($index == 0) --}}
                            <tr>
                                <td>{{ $unit->serial_number }}</td>
                                <td>{{ $unit->description }}</td>
                                <td>{{ $unit->quantity }}</td>
                                <td>{{ $unit->unit_number }}</td>
                                @if ($unit->aquisition_date == null)
                                <td>{{ 'No Date Record.' }}</td>
                                @else
                                    <td>{{ date('F j, Y', strtotime($unit->aquisition_date)) }}</td>
                                @endif
                                <td style="font-size: 12px"><b>{{ $unit->status }}</b></td>
                                <td>{{ $unit->inventory_tag }}</td>
                            </tr>
                            {{-- @else --}}
                            {{-- <tr>
                                    <td>{{ $unit->serial_number }}</td>
                                    <td>{{ $unit->item_description }}</td>
                                    <td>{{ $unit->quantity }}</td>
                                    <td style="font-size: 12px"><b>{{ $unit->status }}</b></td>
                                    <td>{{ $unit->inventory_tag }}</td>
                                </tr> --}}
                            {{-- @endif --}}
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="column">
                Prepared By: <br>
                <br>
                <span class="signee">{{ $prepared_by }}</span>
                <br>
                Main Office <br>
                <br>
                Noted By: <br>
                <br>
                <span class="signee">{{ $lab_oic }}</span>
                <br>
                Laboratory OIC
            </div>
            <div class="column">
                Verified By: <br>
                <br>
                <span class="signee">{{ $verified_by }}</span>
                <br>
                Main Office <br>
                <br>
                <br>
                <br>
                <span class="signee">{{ $it_specialist }}</span>
                <br>
                IT Specialist
            </div>
        </div>
    </div>

</html>
