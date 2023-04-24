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
                    <th>Release BY</th>
                    <th>Actions</th>

                  </tr>
                  </thead>
                  <tbody>
                 
                  @foreach ($borrows as $borrow)
                      <tr>
                      <td class="d-none">{{ $borrow->id }}</td>
                          <td>{{ $borrow->serial_number }}</td>
                          <td>{{ $borrow->first_name }} {{ $borrow->last_name }}</td>
                          <td>{{ $borrow->item_name }}</td>
                          <td>{{ $borrow->release_by }}</td>
                      
                          <td>
                            <a href="{{ route('borrow_item',['id' => $borrow->id, 'serial_number' => $borrow->serial_number]) }}" class="btn btn-sm btn-success" title="Approved">
                                    <i class="fa fa-check"></i></a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#returnModal">Return</button>
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

<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Remarks</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('borrow_item', ['id' => $borrow->id, 'serial_number' => $borrow->serial_number]) }}">
        @csrf
          <div class="mb-3">
          <!-- <input type="hidden" name="id" value="{{ $borrow->id }}">
            <input type="hidden" name="serial_number" value="{{ $borrow->serial_number }}"> -->
            <label for="message-text" class="col-form-label">Remarks:</label>
            <textarea class="form-control" id="item_remark" name="item_remark"></textarea>
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit and Return</button>
      </div>
      </form>
    </div>
  </div>
</div>
