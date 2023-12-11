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
                                                        <th>Trans_ID</th>
                                                        <th>Description</th>
                                                        <th>Borrower Name</th>
                                                        <th>Serial Number</th>
                                                        <th>Date Borrowed</th>
                                                        <th>Due Date</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                              

                                                    @foreach ($overdueItems as $overdueItem)

                                                    <tr>
                                                        <td>{{ $overdueItem->order_id }}</td>
                                                       
                                                        <td>{{ $overdueItem->description }}</td>
                                                        <td>
                                                            {{ $overdueItem->first_name }} {{ $overdueItem->last_name }}
                                                        </td>
                                                        <td>{{ $overdueItem->order_serial_number }}</td>
                                                        <td> {{ \Carbon\Carbon::parse($overdueItem->date_submitted)->format('F d, Y') }}</td>
                                                        <td> {{ \Carbon\Carbon::parse($overdueItem->date_returned)->format('F d, Y') }}</td>
                                                        <td>
                                                           
                                                            <button type="button" class="btn btn-success" id="btn-return-overdue" data-id="{{ $overdueItem->order_item_id }}" data-item="{{ $overdueItem->item_id_borrow }}" data-toggle="modal" data-target="#returnOverdue{{$overdueItem->order_item_id}}">Return</button>
                                                            <button type="button" class="btn btn-danger" id="btn-lost-overdue" data-id="{{ $overdueItem->order_item_id }}" data-item="{{ $overdueItem->item_id_borrow }}" data-toggle="modal" data-target="#lostOverdue{{$overdueItem->order_item_id}}">Replace </button>
                                                        </td>
                                                    </tr>

                                                   

                                                      <div class="modal fade" id="returnOverdue{{$overdueItem->order_item_id}}">
                                                        <div class="modal-dialog ">
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
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->item_id }}" name="itemIdReturn">
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->order_quantity }}" name="borrowOrderQuantity">
                                                              <input type="hidden"  class="form-control" value="{{ $overdueItem->category_name }}" name="categoryName">
                                                        
                                                              <ul class="list-group list-group-unbordered mb-3">
                                                                <li class="list-group-item">
                                                                  <b>Overdue:</b> <a class="float-right">{{ $overdueItem->days_overdue }} Days</a>
                                                                  <input type="hidden"  class="form-control" id="number_of_day_overdue" name="number_of_day_overdue" value="{{ $overdueItem->days_overdue }}"readonly>
                                                                </li>
                                                                <li class="list-group-item">
                                                                  <b>Payment:</b> <a class="float-right">PHP {{ $overdueItem->penalty_fee }}.00</a>
                                                                  <input type="hidden"  class="form-control" id="payment_per_day"  name="payment_per_day" value="{{ $overdueItem->penalty_fee }}" readonly>
                                                                </li>
                                                                @php
                                                                $total = $overdueItem->penalty_fee * $overdueItem->days_overdue;
                                                                $final = $total * $overdueItem->order_quantity;
                                                            @endphp
                                                                <li class="list-group-item">
                                                                  <b>Total:</b> <a class="float-right">PHP {{$final}}.00</a>
                                                                  <input type="hidden"  class="form-control" id="total_amount" value="{{ $final }}" name="total_amount" readonly required>
                                                                </li>
                                                              </ul>
                          
                                                              
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



