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
<div id="success-message"></div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pending Items</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Serial #</th>
                    <th>Name</th>
            
                    <th>Item Name</th>
                    <th>Item Description</th>
                    <th>Actions</th>

                  </tr>
                  </thead>
                  <tbody>
                 
                  @foreach ($pendings as $pending)
                      <tr>
                          <td class="d-none">{{ $pending->id }}</td>
                          <td>{{ $pending->serial_number }}</td>
                          <td>{{ $pending->first_name }} {{ $pending->last_name }}</td>
                          <td>{{ $pending->item_name }}</td>
                          <td>{{ Str::limit($pending->item_description, 20, '...') }}</td>
                      
                          <td>
                            <a href="{{ route('pending_item', $pending->id) }}" class="btn btn-sm btn-success" title="Approved">
                                    <i class="fa fa-check"></i></a>
                            <a href="{{ route('remove_borrow', $pending->id) }}" class="btn btn-sm btn-danger" title="Disregard">
                                    <i class="fa fa-trash"></i></a>
                        </td>
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
