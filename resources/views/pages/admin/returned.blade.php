@extends('layouts.pages.yields')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Borrowings</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>


<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Return Items</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name Of Borrower</th>
                    <th>Item Name</th>
                    <th>Serial #</th>           
                    <th>Item Description</th>
                    <th>Released By</th>
                    <th>Returned To</th>
                    <th>Date Borrowed</th>
                    <th>Date Returned</th>
                  </tr>
                  </thead>
                  <tbody>
                 
                  @foreach ($forReturns as $forReturn)
                      <tr>
                          <td>{{ $forReturn->first_name }} {{ $forReturn->last_name }}</td>
                          <td>{{ $forReturn->item_name }}</td>
                          <td>{{ $forReturn->serial_number }}</td>
                          <td>{{ Str::limit($forReturn->item_description, 20, '...') }}</td>
                          <td>{{ $forReturn->release_by }}</td>
                          <td>{{ $forReturn->return_to }}</td>
                          <td>{{ $forReturn->created_at }}</td>
                          <td>{{ $forReturn->updated_at }}</td>
                      </tr>
                  @endforeach
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
@endsection
