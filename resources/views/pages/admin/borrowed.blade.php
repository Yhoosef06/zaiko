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
                      <th>ID Number</th>
                      <th>Serial #</th>
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
                      <td>{{ $borrow->user_id }}</td>
                      <td>{{ $borrow->order_serial_number}}</td>
                      <td>{{ $borrow->brand }}</td>
                      <td>{{ $borrow->released_by }}</td>
                      <td>{{ $borrow->date_returned }}</td>
                      <td>
                        <button type="button" class="btn btn-primary show-borrow" data-bs-toggle="modal" data-bs-target="#showBorrow{{$borrow->id}}"><i class="fa fa-eye"></i></button>
                        <button type="button" class="btn btn-success" id="btn-return" data-id="{{ $borrow->id }}" data-serial="{{ $borrow->order_serial_number }}" data-bs-toggle="modal" data-bs-target="#returnBorrow"><i class="fa fa-check"></i></button>
                      </td>
                    </tr>

                    <div class="modal fade hide" id="showBorrow{{$borrow->id}}">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Borrowed Item</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>ID Number: </label>
                                  {{ $borrow->user_id }}
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Name: </label>
                                  <span>
                                    @foreach ($users as $user)
                                        @if ($user->id_number == $borrow->user_id)
                                        {{ $user->last_name }}, {{ $user->first_name }} 
                                        @endif
                                  @endforeach
                                  </span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Category: </label>
                                 @foreach ($categories as $category)
                                        @if ($category->id == $borrow->category_id)
                                            {{ $category->category_name }}
                                        @endif
                                  @endforeach
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Brand: </label>
                                 {{ $borrow->brand }}
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Model: </label>
                                  {{ $borrow->model }}
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Serial Number: </label>
                                 {{ $borrow->order_serial_number }}
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Date Return: </label>
                                  {{ $borrow->date_returned }}
                                </div>
                              </div>
                              
                            </div>

                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    
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


      <div class="modal fade hide" id="returnBorrow">
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
            <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                          <option value="Active">Active</option>
                          <option value="Obsolete">Obsolete</option>
                          <option value="Lost">Lost</option>
                          <option value="For Repair">For Repair</option>   
                        </select>
            </div>
            <div class="form-group">
              <label>Quantity</label>
              <input class="form-control" name="quantity_return" placeholder="Enter ...">
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



      <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
