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
                <h3 class="card-title">Borrowed Items</h3>
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
                 
                  @foreach ($borrows as $borrow)
                      <tr>
                          <td>{{ $borrow->serial_number }}</td>
                          <td>{{ $borrow->first_name }} {{ $borrow->last_name }}</td>
                          <td>{{ $borrow->item_name }}</td>
                          <td>{{ Str::limit($borrow->item_description, 20, '...') }}</td>
                      
                          <td><a href="#" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i></a>
                                <a href="3" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i></a>

                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#myModal">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <!-- The Modal -->
                                <div class="modal" id="myModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Deleting Item</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Are you sure you want to delete item?
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <form action="#"
                                                    method="POST" class="form-check-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">Confirm</button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

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
