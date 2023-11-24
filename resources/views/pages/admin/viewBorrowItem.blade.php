@extends('layouts.pages.yields')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
                @foreach($borrows as $index => $borrow)
                        @if($index === 0)
                            <h1>{{ $borrow->last_name }}, {{ $borrow->first_name }}</h1>
                            
                        @endif
                    @endforeach
            </h1>
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
                    <h3 class="card-title"><strong>Transaction #: @foreach($borrows as $index => $borrow)
                      @if($index === 0)
                          <span style="color:green">{{ $borrow->order_id }}</span>
                          
                      @endif
                  @endforeach</strong></h3>

                  
                   <div class="col md-4 text-right">
                    <small class="badge badge-warning"><i class="far fa-clock"></i> Overdue</small></div>
                       
                      
                   
                   
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="borrowed" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="d-none">Transaction ID</th>
                      <th>Description</th>
                      <th>Serial</th>
                      <th>Brand</th>
                      <th>Model</th>
                      <th>QTY</th>
                      <th>Due Date</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($borrows as $borrow)
                    @if ($borrow->date_returned > \Carbon\Carbon::now())
                    <tr>
                      <td class="d-none"> {{ $borrow->order_id }}</td>
                      <td>{{ $borrow->description }}</td>
                      <td>{{ $borrow->order_serial_number }}</td>
                      <td>{{ $borrow->brand }}</td>
                      <td>{{ $borrow->model }}</td>
                      <td>{{ $borrow->order_quantity }}</td>
                      <td>{{ \Carbon\Carbon::parse($borrow->date_returned)->format('F d, Y') }}</td>
                      <td>
                        <button type="button" class="btn btn-success" id="btn-return" data-id="{{ $borrow->order_item_id }}" data-item="{{ $borrow->item_id_borrow }}" data-toggle="modal" data-target="#returnBorrow{{$borrow->order_item_id}}">Return</button>
                        <button type="button" class="btn btn-danger" id="btn-lost" data-id="{{ $borrow->order_item_id }}" data-item="{{ $borrow->item_id_borrow }}" data-toggle="modal" data-target="#lostItem{{$borrow->order_item_id}}">Replace</button>
                      </td>
                    </tr>
                    @else
                    <tr class="bg-warning">
                      <td class="d-none"> {{ $borrow->order_id }}</td>
                      <td >{{ $borrow->description }}</td>
                      <td>{{ $borrow->order_serial_number }}</td>
                      <td>{{ $borrow->brand }}</td>
                      <td>{{ $borrow->model }}</td>
                      <td>{{ $borrow->order_quantity }}</td>
                      <td>{{ \Carbon\Carbon::parse($borrow->date_returned)->format('F d, Y') }}</td>
                      <td>
                        <button type="button" class="btn btn-success" id="btn-return" data-id="{{ $borrow->order_item_id }}" data-item="{{ $borrow->item_id_borrow }}" data-toggle="modal" data-target="#releaseOverdue{{$borrow->order_item_id}}">Return</button>
                        <button type="button" class="btn btn-danger" id="btn-lost" data-id="{{ $borrow->order_item_id }}" data-item="{{ $borrow->item_id_borrow }}" data-toggle="modal" data-target="#lostItem{{$borrow->order_item_id}}">Replace</button>
                      </td>
                    </tr>

                    @endif


                    <div class="modal fade" id="releaseOverdue{{$borrow->order_item_id}}">
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
                            <input type="hidden"  class="form-control" value="{{ $borrow->order_item_id }}" name="orderItemReturn">
                            <input type="hidden"  class="form-control" value="{{ $borrow->item_id_borrow }}" name="itemIdReturn">
                            <input type="hidden"  class="form-control" value="{{ $borrow->order_quantity }}" name="borrowOrderQuantity">
                            <input type="hidden"  class="form-control" value="{{ $borrow->category_name }}" name="categoryName">
                          <div class="form-group">
                                <label>Number Of Day Overdue</label>
                                <input type="number"  class="form-control" id="number_of_day_overdue" name="number_of_day_overdue" value="{{ $borrow->days_overdue }}"readonly>
                                     
                          </div>
                          <div class="form-group">
                            <label>Payment Per Day</label>
                            <input type="number"  class="form-control" id="payment_per_day"  name="payment_per_day" value="{{ $borrow->penalty_fee }}" readonly>
                                 
                        </div>
                        @php
                          $total = $borrow->penalty_fee * $borrow->days_overdue;
                      @endphp
                        <div class="form-group">
                          <label>Total</label>
                          <input type="number"  class="form-control" id="total_amoun" value="{{ $total }}" name="total_amount" readonly required>
                               
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

                   
                      
                      
                        

                   

                    <div class="modal fade hide" id="returnBorrow{{$borrow->order_item_id}}">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Return Item</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form method="POST" action="{{ route('addRemark') }}">
                            @csrf
                          
                            <input type="hidden"  class="form-control" value="{{ $borrow->order_id }}" name="orderTransacId">
                            <input type="hidden"  class="form-control" value="{{ $borrow->order_item_id }}" name="orderItemReturn">
                            <input type="hidden"  class="form-control" value="{{ $borrow->item_id_borrow }}" name="itemIdReturn">
                            <input type="hidden"  class="form-control" value="{{ $borrow->order_quantity }}" name="borrowOrderQuantity">
                            <input type="hidden"  class="form-control" value="{{ $borrow->category_name }}" name="categoryName">
                          <div class="form-group">
                                      <label>Remarks</label>
                                      <textarea class="form-control" rows="3" name="item_remark" placeholder="Enter ..."></textarea>
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

                    <div class="modal fade hide" id="lostItem{{$borrow->order_item_id}}">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Lost Item</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form method="POST" action="{{ route('lostItem') }}">
                            @csrf
                            <input type="hidden"  class="form-control" value="{{ $borrow->order_id }}" name="orderTransacId">
                            <input type="hidden"  class="form-control" value="{{ $borrow->order_item_id }}" name="orderItemReturn">
                            <input type="hidden"  class="form-control" value="{{ $borrow->item_id_borrow }}" name="itemIdReturn">
                           
                            <input type="hidden"  class="form-control" value="{{ $borrow->category_name }}" name="categoryName">
                          <div class="form-group">
                                      <label>Remarks</label>
                                      <textarea class="form-control" rows="3" name="item_remark" placeholder="Enter ..."></textarea>
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
