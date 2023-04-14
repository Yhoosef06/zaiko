<!DOCTYPE html>
<html>

<head>
    <title>Returned Items Report</title>
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
        RETURNED ITEMS REPORT 
    </div>
    <div class="container" id="intro_details">
        <strong>DATE PREPARED:</strong> {{ now()->format('m-d-Y') }} <br>
        <strong>DEPARTMENT / OFFICE:</strong> SCS <br>
    </div>
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Serial #</th>
                    <th scope="col">Description of Item</th>
                    <th scope="col">QTY</th>
                    <th scope="col">UNIT #</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrows as $borrow)
                      <tr>
                          <td>{{ $borrow->serial_number }}</td>
                          <td>{{ $borrow->first_name }} {{ $borrow->last_name }}</td>
                          <td>{{ $borrow->item_name }}</td>
                          <td>{{ Str::limit($borrow->item_description, 20, '...') }}</td>
                      </tr>
                  @endforeach
            </tbody>
        </table>
    </div>

</html>
