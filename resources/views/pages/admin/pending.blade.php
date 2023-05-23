@extends('layouts.pages.yields')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Borrowings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBorrow">
            <i class="fa fa-plus"> </i>
                  Add to Borrow
            </button>
            </ol>
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


<div class="modal fade" id="addBorrow">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Borrow Item</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ route('addOrder') }}">
            @csrf

                  <div class="row">
                    <div class="col-sm-6">
      
                              <div class="form-group">
                                <label>ID Number</label>
                                <div id="user_id_container">
                                <input type="text" id="idNumber" name="idNumber" class="form-control" placeholder="Enter ID Number here...." required>
                                </div>
                               
                        
                              </div>
                            </div>
                    </div>
                    <div class="row" id="profile" style="display: none;">
                    <div class="col-sm-6">
                      
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" readOnly>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" readOnly>
                      </div>
                    </div>
                 </div>

                 <div class="row item-category" id="item-category" style="display: none;">
                    <div class="col-sm-6">
                      
                    <div class="form-group">
                        <label>Item Category</label>
                        <select class="form-control" id="item_category" name="item_category">
                          <option>Select Category</option>
                          @foreach ($items as $item)
                          <option value="{{ $item->category_name }}"> {{ $item->category_name }} </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Serial Number</label>
                        <div id="item-serial">
                        <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Enter Serial Number...">
                        </div>
                      </div>
                    </div>
                 </div>


                 <div class="row item-category" style="display: none;">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                        </div> 
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Model</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                      </div>
                    </div>
                 </div>
              
              
                 <div class="row item-category" style="display: none;">
                    <div class="col-sm-6">
                      
                    <div class="form-group">
                        <label>Item Description</label>
                        <input type="text" class="form-control" id="item_description" name="item_description">
                      </div>
                    </div>
                 </div>

                 <div class="row item-category" style="display: none;">
                    <div class="col-sm-6" id="quantity-order">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" value="0" class="form-control" id="quantity" name="quantity" >
                      </div>
                  </div>
                      <div class="col-sm-6">
                    <div class="form-group">
                        <label>Return Date</label>
                        <input type="date" class="form-control" id="return_date" name="return_date">
                      </div>
                    </div>
                 </div>



              
         
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
</form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        
      </div>
</div>

   

    