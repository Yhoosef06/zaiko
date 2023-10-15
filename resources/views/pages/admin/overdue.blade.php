@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Overdue</h1>
                </div>
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('borrowItem') }}" class="btn btn-primary" >
                            <i class="fa fa-plus"> </i>
                            Add to Borrow
                        </a>
                    </ol>
                </div> --}}
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div id="success-message"></div>
        <div class="container-fluid">



            <div class="row">
                <div class="col-12 col-sm-12">
                
                   
                    <div class="card-body">
                  
                            <div class="row">
                                <div class="col-12">

                                    <div class="card">
                                    
                                        <div class="card-body">
                                            <table id="user-overdue" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>                                         
                                                        <th>Transaction ID</th>
                                                     
                                                        <th>Description</th>
                                                        <th>Student Name</th>
                                                        <th>Date Borrowed</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($overdueItems as $overdueItem)

                                          
                                                    <tr>
                                                        <td>{{ $overdueItem->id }}</td>
                                                       
                                                        <td>{{ $overdueItem->description }}</td>
                                                        <td>
                                                            {{ $overdueItem->first_name }} {{ $overdueItem->last_name }}
                                                        </td>
                                                       
                                                        <td> {{ \Carbon\Carbon::parse($overdueItem->date_submitted)->format('F d, Y') }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary show-borrow" data-bs-toggle="modal" data-bs-target="#showOverdue{{$overdueItem->order_item_id}}">View</button>
                                                            <button type="button" class="btn btn-success" id="btn-return-overdue" data-id="{{ $overdueItem->order_item_id }}" data-item="{{ $overdueItem->item_id_borrow }}" data-bs-toggle="modal" data-bs-target="#returnOverdue{{$overdueItem->order_item_id}}">Return</button>
                                                            <button type="button" class="btn btn-danger" id="btn-lost-overdue" data-id="{{ $overdueItem->order_item_id }}" data-item="{{ $overdueItem->item_id_borrow }}" data-bs-toggle="modal" data-bs-target="#lostOverdue{{$overdueItem->order_item_id}}">Lost</button>
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade hide" id="showOverdue{{$overdueItem->order_item_id}}">
                                                        <div class="modal-dialog modal-lg">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">{{ $overdueItem->last_name }}, {{$overdueItem->first_name}}</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label>ID Number: </label>
                                                                    {{ $overdueItem->user_id }}
                                                                  </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label>Item Description: </label>
                                                                    <span>
                                                                      {{ $overdueItem->description }}
                                                                    </span>
                                                                  </div>
                                                                </div>
                                                              </div>
                                  
                                                              <div class="row">
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label>Category: </label>
                                                                      {{ $overdueItem->category_name }}
                                                                  </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label>Brand: </label>
                                                                   {{ $overdueItem->brand }}
                                                                  </div>
                                                                </div>
                                                              </div>
                                  
                                                              <div class="row">
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label>Model: </label>
                                                                    {{ $overdueItem->model }}
                                                                  </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label>Serial Number: </label>
                                                                   {{ $overdueItem->order_serial_number }}
                                                                  </div>
                                                                </div>
                                                              </div>
                                  
                                                              <div class="row">
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label>Date Return: </label>
                                                                    {{ $overdueItem->date_returned }}
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

                                                      <div class="modal fade hide" id="returnOverdue{{$overdueItem->order_item_id}}">
                                                        <div class="modal-dialog modal-sm">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Return Overdue Item</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('returnOverdueItem') }}">
                                                              @csrf
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->order_item_id }}" name="orderItemReturn">
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->item_id_borrow }}" name="itemIdReturn">
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->order_quantity }}" name="borrowOrderQuantity">
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->category_name }}" name="categoryName">
                                                            <div class="form-group">
                                                                  <label>Number Of Day Overdue</label>
                                                                  <input type="text"  class="form-control"  id="number_of_day_overdue" name="number_of_day_overdue" value="{{ $overdueItem->days_overdue }}"readonly>
                                                                       
                                                            </div>
                                                            <div class="form-group">
                                                              <label>Payment Per Day</label>
                                                              <input type="text"  class="form-control"  name="payment_per_day" id="payment_per_day" required>
                                                                   
                                                          </div>
                                                          <div class="form-group">
                                                            <label>Total</label>
                                                            <input type="text"  class="form-control" id="total_amount" name="total_amount" readonly>
                                                                 
                                                        </div>
                                                            <div class="form-group">
                                                              <label>Quantity</label>
                                                              <select name="quantity_return" class="form-control">
                                                                @for ($i = 1; $i <= $overdueItem->order_quantity; $i++)
                                                                  <option value="{{ $i }}" {{ $i == $overdueItem->order_quantity ? 'selected' : '' }}>
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

                                                      <div class="modal fade hide" id="lostOverdue{{$overdueItem->order_item_id}}">
                                                        <div class="modal-dialog modal-sm">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Lost Item</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('lostOverdueItem') }}">
                                                              @csrf
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->order_item_id }}" name="orderItemReturn">
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->item_id_borrow }}" name="itemIdReturn">
                                                             
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->category_name }}" name="categoryName">
                                                            <div class="form-group">
                                                                        <label>Remarks</label>
                                                                        <textarea class="form-control" rows="3" name="item_remark" placeholder="Enter ..."></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                              <label>Quantity</label>
                                                              <select name="quantity_return" class="form-control">
                                                                @for ($i = 1; $i <= $overdueItem->order_quantity; $i++)
                                                                  <option value="{{ $i }}" {{ $i == $overdueItem->order_quantity ? 'selected' : '' }}>
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
                                    
                                    </div>
                                
                                </div>
                            
                            </div>
                          
        
                      
                  
                    <!-- /.card -->
                  </div>
                
          
              </div>



     
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

