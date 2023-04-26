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
                <h3 class="card-title"><strong>Pending Items</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="pending" class="table table-bordered table-striped">
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
                            <!-- <a href="{{ route('pending_item', ['id' => $pending->id, 'serial_number' => $pending->serial_number]) }}" class="btn btn-sm btn-success" title="Approved">
                                    <i class="fa fa-check"></i></a> -->
                            <form class="form_delete_btn" method="POST" action="{{ route('pending_item', ['id' => $pending->id, 'serial_number' => $pending->serial_number]) }}">
                            @csrf
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <input type="hidden" name="id" value="{{ $pending->id }}">
                            <input type="hidden" name="serial_number" value="{{ $pending->serial_number }}">
                              <button type="submit" class="btn btn-success borrowed-approve"><i class="fa fa-check"></i></button>
                            </div>
                            <input type="number" placeholder="Number of Days" name="number_of_days" class="form_control">
                          </div>
                        </form>
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
