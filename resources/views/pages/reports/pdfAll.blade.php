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
        </div>
        <div class="container" id="intro_details">
            <strong>DATE PREPARED:</strong> {{ now()->format('F j, Y') }} <br>
            <strong>DEPARTMENT / OFFICE:</strong> {{ $department }} <br>
            <strong>SPECIFIC LOCATION:</strong>{{ $currentLocation->room_name }} <br>
            <strong>SHOOL YEAR:</strong>{{ $term->semester }} {{ date('Y', strtotime($term->start_date)) }} -
            {{ date('Y', strtotime($term->end_date . ' +1 year')) }}
        </div>
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Part Number</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Model</th>
                        <th scope="col">Description</th>
                        <th scope="col">QTY</th>
                        <th scope="col">Acquisition Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $item->serial_number ? $item->serial_number : 'N/A' }}</td>
                            <td>{{ $item->part_number ? $item->part_number : 'N/A' }}</td>
                            <td>{{ $item->brand ? $item->brand->brand_name : 'N/A' }}</td>
                            <td>{{ $item->model ? $item->model->model_name : 'N/A' }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->aquisition_date }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <strong>No data available.</strong>
                            </td>
                        </tr>
                    @endforelse

                    @forelse ($missingItems as $item)
                        <tr>
                            <td>{{ $item->serial_number ? $item->serial_number : 'N/A' }}</td>
                            <td>{{ $item->part_number ? $item->part_number : 'N/A' }}</td>
                            <td>{{ $item->brand ? $item->brand->brand_name : 'N/A' }}</td>
                            <td>{{ $item->model ? $item->model->model_name : 'N/A' }}</td>
                            <td>{{ $item->description }}</td>
                            @foreach ($item->itemLogs as $log)
                                @if ($log->mode == 'Missing')
                                    <td>{{ $log->quantity }}</td>
                                    {{-- <td>{{ date('m-d-Y', strtotime($log->date)) }}</td> --}}
                                @endif
                            @endforeach
                            <td>{{ $item->aquisition_date }}</td>
                            <td>Missing</td>
                        </tr>
                    @empty
                        {{-- <tr>
                            <td colspan="7">
                                <strong>No data available.</strong>
                            </td>
                        </tr> --}}
                    @endforelse

                    @foreach ($transferredItems as $item)
                        @if ($status == 'Transferred')
                            @if ($item->itemLogs)
                                @foreach ($item->itemLogs as $log)
                                    @if ($log->mode == 'Transferred' && $log->roomTo && $log->roomTo->room_name != $currentLocation->room_name)
                                        <tr>
                                            <td>{{ $item->serial_number ? $item->serial_number : 'N/A' }}</td>
                                            <td>{{ $item->part_number ? $item->part_number : 'N/A' }}</td>
                                            <td>{{ $item->brand ? $item->brand->brand_name : 'N/A' }}</td>
                                            <td>{{ $item->model ? $item->model->model_name : 'N/A' }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $log->quantity }}</td>
                                            {{-- <td>{{ $log->date }}</td> --}}
                                            <td>Transferred</td>
                                            <td>{{ $item->aquisition_date }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @endforeach

                    @forelse ($replacementItems as $item)
                        <tr>
                            <td>{{ $item->serial_number ? $item->serial_number : 'N/A' }}</td>
                            <td>{{ $item->part_number ? $item->part_number : 'N/A' }}</td>
                            <td>{{ $item->brand ? $item->brand->brand_name : 'N/A' }}</td>
                            <td>{{ $item->model ? $item->model->model_name : 'N/A' }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->quantity }}</td>
                            {{-- <td>{{ date('m-d-Y', strtotime($item->itemLog->date)) }} </td> --}}
                            <td>{{ $item->aquisition_date }}</td>
                            <td>Transferred</td>
                            {{-- <td>{{ $item->inventory_tag }}</td> --}}
                        </tr>
                    @empty
                        {{-- <tr>
                            <td colspan="7">
                                <strong>No data available.</strong>
                            </td>
                        </tr> --}}
                    @endforelse
                </tbody>
            </table>

            {{-- SIGNATORIES --}}
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
