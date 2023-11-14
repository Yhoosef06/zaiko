@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @foreach($orders as $index => $item)
                        @if($index === 0)
                            <h1>{{ $item->last_name }}, {{ $item->first_name }}</h1>
                        @endif
                    @endforeach
                </div>

                <div class="col-sm-6">
        
                  <div class="form-group">
                      <div id="search-item-user-to-borrow">
                          <input type="text" id="searchItemUser" name="searchItemUser" class="form-control"
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
                    <input type="text" id="order-user-id" name="order-id" value="@foreach($orders as $index => $item)
                    @if($index === 0)
                        {{$item->order_id}}
                    @endif
                 @endforeach" class="form-control"  style="display:none;">
                    <div class="card-body table-responsive p-0" id="viewOrderUserShowTable" style="height: 130px; display:none;">
                      <table class="table table-head-fixed text-nowrap" id="orderUser">
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
                    <div class="card-body table-responsive p-0" style="height: 400px;">
                      
                        <form id="submitFormUser" method="POST">
                          @csrf
                          <table class="table table-head-fixed text-nowrap" id="submitUser">
                            <thead>
                              <tr>
                                <th class="d-none">Order Item Temp</th>
                                <th class="d-none">ORDER ID</th>
                                <th class="d-none">Item ID</th>
                                <th class="d-none">Duration</th>
                                <th style="background-color:#28a745; color:aliceblue">Brand</th>
                                <th style="background-color:#28a745; color:aliceblue">Model</th>
                                <th style="background-color:#28a745; color:aliceblue">Description</th>
                                <th style="background-color:#28a745; color:aliceblue">Serial</th>
                                <th style="background-color:#28a745; color:aliceblue">Quantity</th>
                                <th style="background-color:#28a745; color:aliceblue">Option</th>
                              </tr>
                            </thead>
                            <tbody>
                            
                              @php
                              $counter = 0;  
                              @endphp
                              
                          @foreach ($orders as $item)
                             
                            @if (empty($item->temp_serial_number) && $item->serial_number != 'N/A')
                           
                                @for ($i = 1; $i <= $item->temp_quantity; $i++)
                                @php
                                $counter++;
                                @endphp
                                        <tr>
                                          <td class="d-none">
                                            <input type="text" name="orderItemTemp" value="{{ $item->orderItempId }}">
                                          </td>
                                          <td class="d-none">
                                            <input type="text" name="order_id[]" value="{{ $item->order_id }}"> {{ $item->order_id }}
                                          </td>
                                          <td class="d-none">
                                            <input type="text" name="itemId[]" id="itemID_{{ $counter }}">
                                          </td>
                                          <td class="d-none">
                                            <input type="text" name="duration[]" id="duration_{{ $counter }}">
                                          </td>
                                          <td>{{ $item->brand_name }} </td>
                                          <td>{{ $item->model_name }}</td>
                                          <td>{{ $item->description }} </td>
                                          <td>
                                            <script>
                                              var itemData = @json($item);
                                          </script>
                                            <div id="user_serial_{{ $counter }}">
                                              <input type="text" name="user_serial_number[]" id="search_for_serial_{{ $counter }}" class="form-control serial-input" required>
                                            </div>
                                          </td>
                                          <td>
                                            <input type="hidden" name="quantity[]" value="1">1
                                          </td>
                                          <td>
                                            <a data-id="{{ $item->orderItempId }}" class="btn btn-danger order-user-remove">Remove</a>
                                          </td>
                                        </tr>
                                    @endfor
                                
                          
                                  
                             @elseif($item->serial_number === 'N/A')
                                  <tr>
                                    <td class="d-none">
                                      <input type="text" name="orderItemTemp" value="{{ $item->orderItempId }}">
                                    </td>
                                    <td class="d-none">
                                      <input type="text" name="order_id[]" value="{{ $item->order_id }}"> {{ $item->order_id }}
                                    </td>
                                    <td class="d-none">
                                      <input type="text" name="itemId[]" value="{{ $item->item_id}}">
                                    </td>
                                    <td class="d-none">
                                      <input type="text" name="duration[]" value="{{ $item->temp_duration }}">
                                    </td>
                                    <td>{{ $item->brand_name }}</td>
                                    <td>{{ $item->model_name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                      <input type="hidden" name="user_serial_number[]" value="{{ $item->serial_number}}">{{ $item->serial_number }}
                                    </td>
                                    <td>
                                      @php
                                      $borrowedQty = 0;
                                      $missingQty = 0;
                                      foreach ($borrowedList as $borrowed) {
                                          if ($borrowed->item_id == $item->item_id) {
                                              $borrowedQty += $borrowed->order_quantity;
                                          }
                                      }
                                      
                                      foreach ($missingList as $missing) {
                                          if ($missing->item_id == $item->item_id) {
                                              $missingQty += $missing->quantity;
                                          }
                                      }
                              
                                      $availableQty = $item->itemQty - ($borrowedQty + $missingQty);
                                     @endphp
                              
                                  
                                      <select name="quantity[]" class="form-control">
                                        @for ($i = 1; $i <= $availableQty; $i++)
                                        <option value="{{ $i }}" {{ $i == $item->orderQty ? 'selected' : '' }}>
                                          {{ $i }}
                                        </option>
                                        @endfor
                                      </select>
                                    </td>
                                    <td>
                                      <a  data-id="{{ $item->orderItempId }}" class="btn btn-danger order-user-remove">Remove</a>
                                    </td>
                                  </tr>
                              @else
                              <tr>
                                <td class="d-none">
                                  <input type="text" name="orderItemTemp" value="{{ $item->orderItempId }}">
                                </td>
                                <td class="d-none">
                                  <input type="text" name="order_id[]" value="{{ $item->order_id }}"> {{ $item->order_id }}
                                </td>
                                <td class="d-none">
                                  <input type="text" name="itemId[]" value="{{ $item->item_id}}">
                                </td>
                                <td class="d-none">
                                  <input type="text" name="duration[]" value="{{ $item->temp_duration }}">
                                </td>
                                <td>{{ $item->brand_name }}</td>
                                <td>{{ $item->model_name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                  <input type="hidden" name="user_serial_number[]" value="{{ $item->temp_serial_number}}">{{ $item->temp_serial_number }}
                                </td>
                                <td>
                                  <input type="hidden" name="quantity[]" value="1">1
                                </td>
                                <td>
                                  <a  data-id="{{ $item->orderItempId }}" class="btn btn-danger order-user-remove">Remove</a>
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
                      <input type="text" id="student_id_added_user" name="student_id_added_user" value="@foreach($orders as $index => $item)
                    @if($index === 0)
                        {{$item->id_number}}
                    @endif
                @endforeach" class="form-control" style="display:none;">
                <button type="submit" class="btn btn-primary">Submit</button>
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

