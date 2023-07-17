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
                      <th>Order ID</th>
                      <th>Date Borrowed</th>
                      <th>Name</th>
                      <th>Serial</th>
                      <th>QTY Borrowed</th>
                      <th>Brand</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($borrows as $borrow)
                    <tr>
                      <td>{{ $borrow->order_id }}</td>
                      <td>{{ \Carbon\Carbon::parse($borrow->date_submitted )->format('F d, Y') }}</td>
                      <td>{{ $borrow->last_name }}, {{$borrow->first_name}}</td>
                      <td>{{ $borrow->order_serial_number }}</td>
                      <td>{{ $borrow->order_quantity }}</td>
                      <td>{{ $borrow->brand }}</td>
                      <td>
                        <button type="button" class="btn btn-primary show-borrow" data-bs-toggle="modal" data-bs-target="#showBorrow{{$borrow->order_item_id}}"><i class="fa fa-eye"></i></button>
                        <button type="button" class="btn btn-success" id="btn-return" data-id="{{ $borrow->order_item_id }}" data-item="{{ $borrow->item_id_borrow }}" data-bs-toggle="modal" data-bs-target="#returnBorrow{{$borrow->order_item_id}}"><i class="fa fa-check"></i></button>
                      </td>
                    </tr>

                    <div class="modal fade hide" id="showBorrow{{$borrow->order_item_id}}">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">{{ $borrow->last_name }}, {{$borrow->first_name}}</h4>
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
                                  <label>Item Description: </label>
                                  <span>
                                    {{ $borrow->description }}
                                  </span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Category: </label>
                                    {{ $borrow->category_name }}
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


                    <div class="modal fade hide" id="returnBorrow{{$borrow->order_item_id}}">
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
                            <input type="text"  class="form-control" value="{{ $borrow->order_item_id }}" name="orderItemReturn">
                            <input type="text"  class="form-control" value="{{ $borrow->item_id_borrow }}" name="itemIdReturn">
                            <input type="text"  class="form-control" value="{{ $borrow->order_quantity }}" name="borrowOrderQuantity">
                            <input type="text"  class="form-control" value="{{ $borrow->category_name }}" name="categoryName">
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
                            <select name="quantity_return" class="form-control">
                              @for ($i = 1; $i <= $borrow->order_quantity; $i++)
                                <option value="{{ $i }}" {{ $i == $borrow->order_quantity ? 'selected' : '' }}>
                                  {{ $i }}
                                </option>
                              @endfor
                            </select>
                           
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


    


      <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
