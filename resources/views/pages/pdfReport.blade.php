<!DOCTYPE html>
<html>

<head>
    <title>Inventory Report for {{ $location }}</title>
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

    .signees {
        column-count: 2;
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
        <strong>DATE PREPARED:</strong> {{ now()->format('m-d-Y') }} <br>
        <strong>DEPARTMENT / OFFICE:</strong> {{ $department }} <br>
        <strong>SPECIFIC LOCATION:</strong> {{ $location }}
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
                @foreach ($items as $item)
                    @if ($item->location == $location)
                        <tr>
                            <td>{{ $item->serial_number }}</td>
                            <td>{{ $item->item_description }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit_number }}</td>
                            <td>{{ $item->aquisition_date }}</td>
                            <td style="font-size: 12px"><b>{{ $item->status }}</b></td>
                            <td>{{ $item->inventory_tag }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="column">
                Prepared By: <br>
                <br>
                ________________________ <br>
                Main Office <br>
                <br>
                Noted By: <br>
                <br>
                _________________________ <br>
                Laboratory OIC
            </div>
            <div class="column">
                Verified By: <br>
                <br>
                ________________________ <br>
                Main Office <br>
                <br>
                <br>
                <br>
                _________________________ <br>
                IT Specialist
            </div>
        </div>
    </div>

</html>
