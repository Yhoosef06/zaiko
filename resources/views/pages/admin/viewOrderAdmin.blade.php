@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @foreach($order as $index => $item)
                        @if($index === 0)
                            <h1>{{ $item->last_name }}, {{ $item->first_name }}</h1>
                            <input type="hidden" name="orderID" id="orderID" value="{{ $item->order_id }}">
                        @endif
                    @endforeach
                </div>

                <div class="col-sm-6">
        
                  <div class="form-group">
                      <div id="search-item-admin-to-borrow">
                          <input type="text" id="searchItemAdmin" name="searchItemAdmin" class="form-control"
                              placeholder="Search Item to Borrow - Serial Number or Item Description" required>
                      </div>     
                  </div>

                  

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
                   
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" id="viewOrderAdminShowTable" style="height: 130px; display:none">
                      <table class="table table-head-fixed text-nowrap" id="orderAdmin">
                        <thead>
                          <tr>
                            <th class="d-none">ID</th>
                            <th class="d-none">ItemId</th>
                            <th class="d-none">Order ID</th>
                            <th style="background-color:#343a40; color:aliceblue">Brand</th>
                            <th style="background-color:#343a40; color:aliceblue">Model</th>
                            <th style="background-color:#343a40; color:aliceblue">Desctiption</th>
                  
                            <th style="background-color:#343a40; color:aliceblue">Quantity</th>
                            <th style="background-color:#343a40; color:aliceblue">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                        
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
              </div>



              <div class="row">
                <div class="col-12">
                  <div class="card">
                   
                    <!-- /.card-header -->
                    <input type="text" id="student_id_added_admin" name="student_id_added_admin" value="@foreach($order as $index => $item)
                    @if($index === 0)
                        {{$item->user_id}}
                    @endif
                 @endforeach" class="form-control" style="display:none;">
                 <input type="text" id="order-id" name="order-id" value="@foreach($order as $index => $item)
                    @if($index === 0)
                        {{$item->order_id}}
                    @endif
                 @endforeach" class="form-control" style="display:none;">
                    <form id="submitForm" method="POST" >
                    <div class="card-body table-responsive p-0" style="height: 400px;">
                     
                        @csrf
                        <table class="table table-head-fixed text-nowrap" id="submitAdmin">
                          <thead>
                            <tr>
                              <th class="d-none">Order ID</th>
                              <th class="d-none">OrderItem ID</th>
                              <th class="d-none">Item ID</th>
                              <th style="background-color:#28a745; color:aliceblue">Brand</th>
                              <th style="background-color:#28a745; color:aliceblue">Model</th>
                              <th style="background-color:#28a745; color:aliceblue">Description</th>
                              <th style="background-color:#28a745; color:aliceblue">Serial</th>
                              <th style="background-color:#28a745; color:aliceblue">Quantity</th>
                              <th style="background-color:#28a745; color:aliceblue">Option</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($order as $index => $item)
                              @if ($item->category_name =="Tools")
                                <tr>
                                  <td class="d-none">
                                    <input type="hidden" name="order_id[]" value="{{ $item->order_id }}">
                                    {{ $item->order_id }}
                                  </td>
                                  <td class="d-none">
                                    <input type="hidden" name="order_item_id[]" id="order_item_id_{{ $index }}" value="{{ $item->order_item_id }}">
                                    {{ $item->order_item_id }}
                                  </td>
                                  <td class="d-none">
                                    <input type="hidden" name="item_id[]" value="{{ $item->item_id }}" id="item_id_{{ $index }}">
                                    {{ $item->item_id }}
                                  </td>
                                  <td>{{ $item->brand }}</td>
                                  <td>{{ $item->model }}</td>
                                  <td>{{ $item->description }}</td>
                                  <td>{{ $item->serial_number }}</td>
                                  <td id="quantity_{{ $index }}">
                                    <select name="quantity[]" class="form-control" onchange="updateItemQuantity(this.value, {{ $index }})">
                                      @for ($i = 1; $i <= $item->quantity; $i++)
                                        <option value="{{ $i }}" {{ $i == $item->order_quantity ? 'selected' : '' }}>
                                          {{ $i }}
                                        </option>
                                      @endfor
                                    </select>
                                  </td>
                                  <td>
                                    <a href="#" data-id="{{ $item->order_item_id }}" class="btn btn-danger order-admin-remove">Remove</a> 
                                  </td>
                                </tr>
                              @else
                                <tr>
                                  <td class="d-none">
                                    <input type="hidden" name="order_id[]" value="{{ $item->order_id }}">
                                    {{ $item->order_id }}
                                  </td>
                                  <td class="d-none">
                                    <input type="hidden" name="order_item_id[]" id="order_item_id_{{ $index }}" value="{{ $item->order_item_id }}">
                                    {{ $item->order_item_id }}
                                  </td>
                                  <td class="d-none">
                                    <input type="hidden" name="item_id[]" value="{{ $item->item_id }}" id="item_id_{{ $index }}">
                                    {{ $item->item_id }}
                                  </td>
                                  <td>{{ $item->brand }}</td>
                                  <td>{{ $item->model }}</td>
                                  <td>{{ $item->description }}</td>
                                  <td>{{ $item->serial_number }}</td>
                                  <td>
                                    <input type="hidden" name="quantity[]" value="{{ $item->order_quantity }}">
                                    {{ $item->order_quantity }}
                                  </td>
                                  <td>
                                    <a href="#" data-id="{{ $item->order_item_id }}" class="btn btn-danger order-admin-remove">Remove</a>
                                  </td>
                                </tr>
                              @endif
                            @endforeach
                          </tbody>
                        </table>
                        
                    </div>
                    
                    <!-- /.card-body -->
                  </div>
                  <div class="row mb-2">
                      
                    <div class="col-sm-6">
                      <button type="submit" id="button-submit-admin" class="btn btn-primary">Submit</button>
                    </div>
                    </div>
                  </form>
                  <!-- /.card -->
                </div>
              </div>



              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
            
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

