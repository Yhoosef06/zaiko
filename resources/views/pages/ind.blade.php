<!DOCTYPE html>
<html>
<head>
  <title>Laravel 8 Generate PDF Using DomPDF - Techsolutionstuff</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

  <div class="container">
    <div class="row">
      <div class="col-lg-12" style="margin-top: 15px ">
        <div class="pull-left">
          <h2>Laravel 8 Generate PDF Using DomPDF - Techsolutionstuff</h2>
        </div>
        <div class="pull-right">
          <a class="btn btn-primary" href="{{route('pdf_view',['download'=>'pdf'])}}">Download PDF</a>
        </div>
      </div>
    </div><br>

    <table class="table table-striped">
      <tr>
        <th>ID</th>
        <th>Name</th>
      </tr>

      @foreach ($room as $room)
      <tr>
        <td>{{ $room->id }}</td>
        <td>{{ $room->room_name }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</body>
</html>
