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
           
            <!-- <form action="{{ route('download_borrowed_pdf', ['download' => 'pdf']) }}" method="POST"> -->
              <!-- @csrf -->
              <div class="card">
                <div class="card-header row">
                  <div class="col md-8">
                    <h3 class="card-title"><strong>Borrowed Items</strong></h3>
                  </div>
                  <div class="col md-4 text-right">
                    <Button type="submit" class="btn btn-success">Generate Report</Button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="borrowed" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                     <th class="d-none">ID #</th>
                      <th>Serial #</th>
                      <th>Name</th>
                      <th>Brand</th>
                      <th>Release BY</th>
                      <th>Return Date</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                  
                          @foreach ($borrows as $borrow)
                            <tr>
                            <td class="d-none">{{ $borrow->id }}</td>
                                <td>{{ $borrow->serial_number }}</td>
                                <td>{{ $borrow->first_name }} {{ $borrow->last_name }}</td>
                                <td>{{ $borrow->brand }}</td>
                                <td>{{ $borrow->release_by }}</td>
                                <td>{{ $borrow->return_date}}</td>
                            
                                <td>
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showBorrow"><i class="fa fa-eye"></i></button>
                                  <button type="button" class="btn btn-success" id="btn-return" data-id="{{ $borrow->id }}" data-serial="{{ $borrow->serial_number }}" data-bs-toggle="modal" data-bs-target="#returnBorrow"><i class="fa fa-check"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            <!-- </form> -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>


@endsection


<div class="modal fade" id="showBorrow">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Borrowed Item</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



      <div class="modal fade" id="returnBorrow">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Remark</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ route('addRemark') }}">
              @csrf
              <input type="hidden"  class="form-control" id="idreturn" name="idreturn">
              <input type="hidden"  class="form-control" id="serialreturn" name="serialreturn">
            <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control" rows="3" name="item_remark" placeholder="Enter ..."></textarea>
            </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
          </div>
      
        </div>
       
      </div>



     
