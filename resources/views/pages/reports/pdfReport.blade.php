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
    <div class="container">
        <div class="container" style="font-weight: 800; font-size:18pt; text-align:center">
            UNIVERSITY OF SAN JOSE-RECOLETOS <br>
            Inventory Report
            <div class="container mt-2">
                <strong style="font-family: sans-serif; font-size:16pt; text-align:center">List of {{ $status }}
                    Items</strong>
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
                        <th scope="col">Item #</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Model</th>
                        <th scope="col">Description</th>
                        <th scope="col">QTY</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">
                            @if ($isLog)
                                @if ($status == 'Missing')
                                    Date Missing
                                @elseif ($status == 'Transferred')
                                    Date Transferred
                                @endif
                            @else
                                Acquisition Date
                            @endif
                        </th>
                        @if ($isStatus)
                            <th scope="col">Property Sticker</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!$items->isEmpty())
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->brand->brand_name }}</td>
                                <td>
                                    @if ($item->model == null)
                                        No Model
                                    @else
                                        {{ $item->model->model_name }}
                                    @endif
                                </td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->aquisition_date }}</td>
                                <td>{{ $item->inventory_tag }}</td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($itemLog as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->item->brand->brand_name }}</td>
                                <td>
                                    {{ $item->item->model->model_name }}
                                </td>
                                <td>{{ $item->item->description }}</td>
                                <td>{{ $item->quantity }}</td>
                                @if ($status == 'Transferred')
                                <td>{{ $item->roomFrom->room_name }}</td>
                                <td>{{ $item->roomTo->room_name }}</td>
                            @endif
                                <td>{{ date('m-d-Y', strtotime($item->date)) }} </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <div class="row">
                <div class="column">
                    Prepared By: <br>
                    <br>
                    <span class="signee">{{ $prepared_by }}</span>
                    <br>
                    {{ $role_1 }}<br>
                    <br>
                    Noted By: <br>
                    <br>
                    <span class="signee">{{ $noted_by }}</span>
                    <br>
                    {{ $role_3 }}
                </div>
                <div class="column">
                    Verified By: <br>
                    <br>
                    <span class="signee">{{ $verified_by }}</span>
                    <br>
                    {{ $role_2 }} <br>
                    <br>
                    Approved By: <br>
                    <br>
                    <span class="signee">{{ $approved_by }}</span>
                    <br>
                    {{ $role_4 }}
                </div>
            </div>
        </div>
    </div>


</html>