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
            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#addOrder"><i class="fa fa-plus"> </i> Add Order</button>
            </ol>
          </div><!-- /.col -->
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


<div class="modal fade" id="addOrder">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Order</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


            <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>ID Number</label>
                        <input type="text" class="form-control" id="idNumber" name="idNumber" placeholder="Enter ID Number">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control"  readonly>
                      </div>
                    </div>
                  </div>

                  <!-- input states -->
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Item Category</label>
                        <select class="form-control" id="selectCategory">
                          <option>Select Category</option>
                          @foreach ( $itemCategories as $itemCategory )
                          <option>{{ $itemCategory->category_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6" id="pc" style="display: none;">
                      <div class="form-group">
                        <label>Serial Nuber</label>
                        <select class="form-control">
                          <option>PC's</option>
                          @foreach ($pc as $pcs)
                          <option>{{ $pcs->serial_number }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6" id="monitor" style="display: none;">
                      <div class="form-group">
                        <label>Serial Number</label>
                        <select class="form-control">
                          <option>Monitors</option>
                         @foreach ($monitors as $monitor)
                          <option>{{ $monitor->serial_number }}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6" id="mobileDev" style="display: none;">
                      <div class="form-group">
                        <label>Serial Number</label>
                        <select class="form-control">
                          <option>Mobile Device</option>
                          @foreach ($mobileDevs as $mobileDev)
                          <option>{{ $mobileDev->serial_number }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6" id="peripheral" style="display: none;">
                      <div class="form-group">
                        <label>Serial Number</label>
                        <select class="form-control">
                          <option>Peripherals</option>
                          @foreach ($peripherals as $peripheral)
                          <option>{{ $peripheral->serial_number }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6" id="microcontroller" style="display: none;">
                      <div class="form-group">
                        <label>Serial Number</label>
                        <select class="form-control">
                          <option>Microcontrollers</option>
                          @foreach ($microControllers as $microController)
                          <option>{{ $microController->serial_number }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6" id="kit" style="display: none;">
                      <div class="form-group">
                        <label>Serial Number</label>
                        <select class="form-control">
                          <option>Kits</option>
                          @foreach ($kits as $kit)
                          <option>{{ $kit->serial_number }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6" id="tool" style="display: none;">
                      <div class="form-group">
                        <label>Serial Number</label>
                        <select class="form-control">
                          <option>Tools</option>
                          @foreach ($tools as $tool)
                          <option>{{ $tool->serial_number }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>


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
