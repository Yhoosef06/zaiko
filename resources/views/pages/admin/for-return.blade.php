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
                    <th>Serial #</th>
                    <th>Name</th>
                    <th>Item Name</th>
                    <th>Release BY</th>
                    <th>Return TO</th>
                    <th>Date Return</th>

                  </tr>
                  </thead>
                  <tbody>
                 
                  @foreach ($forReturns as $forReturn)
                      <tr>
                          <td>{{ $forReturn->serial_number }}</td>
                          <td>{{ $forReturn->first_name }} {{ $forReturn->last_name }}</td>
                          <td>{{ $forReturn->item_name }}</td>
                          <td>{{ $forReturn->release_by }}</td>
                          <td>{{ $forReturn->return_to }}</td>
                      
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
