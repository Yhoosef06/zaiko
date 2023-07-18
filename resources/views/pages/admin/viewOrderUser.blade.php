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
                                <th class="d-none">ORDER ID</th>
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
                              {{-- @dd($orders); --}}
                              @foreach ($orders as $item)
                              @if ($item->category_name === 'Tools')
                              <tr>
                                <td  class="d-none">
                                  <input type="hidden" name="order_id[]" value="{{ $item->order_id }}"> {{ $item->order_id }}
                                </td>
                                <td  class="d-none">
                                  <input type="hidden" name="itemId[]" value="{{ $item->item_id}}">{{ $item->item_id}}
                                </td>
                                <td>{{ $item->brand }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                  <input type="hidden" name="user_serial_number[]" value="{{ $item->serial_number}}">{{ $item->serial_number }}
                                </td>
                                <td>
                                  <select name="quantity[]" class="form-control">
                                    @for ($i = 1; $i <= $item->itemQuantity; $i++)
                                    <option value="{{ $i }}" {{ $i == $item->temp_quantity ? 'selected' : '' }}>
                                      {{ $i }}
                                    </option>
                                    @endfor
                                  </select>
                                </td>
                                <td>
                                  <a href="#" class="btn btn-danger">Remove</a>
                                </td>
                              </tr>
                              @else
                              @if (empty($item->temp_serial_number))
                              @for ($i = 1; $i <= $item->temp_quantity; $i++)
                              <tr>
                                <td  class="d-none">
                                  <input type="hidden" name="order_id[]" value="{{ $item->order_id }}"> {{ $item->order_id }}
                                </td>
                                <td  class="d-none">
                                  <input type="text" name="itemId[]" id="itemID_{{ $i }}">
                                </td>
                                <td>{{ $item->brand }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                  <div id="user_serial_{{ $i }}">
                                    <input type="text" name="user_serial_number[]" id="search_for_serial_{{ $i }}" class="form-control" required>
                                  </div>
                                </td>
                                <td>
                                  <input type="hidden" name="quantity[]" value="1">1
                                </td>
                                <td>
                                  <a href="#" class="btn btn-danger">Remove</a>
                                </td>
                              </tr>
                              @endfor
                              @else
                              <tr>
                                <td  class="d-none">
                                  <input type="hidden" name="order_id[]" value="{{ $item->order_id }}"> {{ $item->order_id }}
                                </td>
                                <td  class="d-none">
                                  <input type="hidden" name="itemId[]" value="{{ $item->item_id}}">{{ $item->item_id}}
                                </td>
                                <td>{{ $item->brand }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                  <input type="hidden" name="user_serial_number[]" value="{{ $item->serial_number}}">{{ $item->serial_number }}
                                </td>
                                <td>
                                  <input type="hidden" name="quantity[]" value="1">1
                                </td>
                                <td>
                                  <a href="#" class="btn btn-danger">Remove</a>
                                </td>
                              </tr>
                              @endif
                              @endif
                              @endforeach
                            </tbody>
                          </table>
                          
                          <div class="row mb-2">
                            <div class="col-sm-6">
                              <input type="date" class="form-control" name="date_returned">
                              <input type="text" id="student_id_added_user" name="student_id_added_user" value="@foreach($orders as $index => $item)
                            @if($index === 0)
                                {{$item->id_number}}
                            @endif
                        @endforeach" class="form-control" style="display:none;">
                            </div>
                            <div class="col-sm-6">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                          </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                  </div>
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

