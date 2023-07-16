@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
        
                    <div class="form-group">
                        <label>ID Number</label>
                        <div id="user_id_container">
                            <input type="text" id="userIdNumber" name="userIdNumber" value="@foreach($order as $index => $item)
                            @if($index === 0)
                                {{$item->user_id}}
                            @endif
                        @endforeach" class="form-control"
                              readonly>
                        </div>     
                    </div>

                    

                </div>
            </div>

            <div class="row" id="search-serial-desc">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Search Item</label>
                        <div id="search-item-admin-added">
                            <input type="text" id="admin_search_item" name="admin_search_item" class="form-control"
                                placeholder="Search Item to Borrow - Serial Number or Item Description"
                                required>
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
                    <div class="card-body table-responsive p-0" id="showNotAddedAdmin" style="height: 130px; display:none">
                      <table class="table table-head-fixed text-nowrap" id="notAddedAdmin">
                        <thead>
                          <tr>
                            <th class="d-none">ID</th>
                            <th class="d-none">ItemId</th>
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
                     
                    <input type="text" id="student_id_added" name="student_id_added" value="@foreach($order as $index => $item)
                    @if($index === 0)
                        {{$item->user_id}}
                    @endif
                 @endforeach" class="form-control" style="display:none;">
                    <form method="POST" id="submitAdmin">
                      @csrf
              
                    
                    <table class="table table-head-fixed text-nowrap">
                      <thead>
                          <tr>
                      
                              <th class="d-none">Order ID</th>
                              <th class="d-none">OrderItem ID</th>
                              <th style="background-color:#28a745; color:aliceblue">Brand</th>
                              <th style="background-color:#28a745; color:aliceblue">Model</th>
                              <th style="background-color:#28a745; color:aliceblue">Description</th>
                              <th style="background-color:#28a745; color:aliceblue">Serial</th>
                              <th style="background-color:#28a745; color:aliceblue">Quantity</th>
                              <th style="background-color:#28a745; color:aliceblue">Option</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($order as $item)
                          @if ($item->category_name =="Tools")
                            <tr>
                              <td class="d-none"><input type="hidden" name="order_id[]" value="{{ $item->order_id }}">{{ $item->order_id }}</td>
                              <td class="d-none"><input type="hidden" name="order_item_id[]" value="{{ $item->order_item_id }}">{{ $item->order_item_id }}</td>
                              <td>{{ $item->brand }}</td>
                              <td>{{ $item->model }}</td>
                              <td>{{ $item->description }}</td>
                              <td>{{ $item->serial_number }}</td>
                              <td>
                                <select name="quantity[]" class="form-control">
                                  @for ($i = 1; $i <= $item->available_quantity + $item->order_quantity; $i++)
                                    <option value="{{ $i }}" {{ $i == $item->order_quantity ? 'selected' : '' }}>
                                      {{ $i }}
                                    </option>
                                  @endfor
                                </select>
                            </td>
                              <td>
                                <a href="" class="btn btn-danger">Remove</a> 
                              </td>
                          </tr>
                          @else
                            <tr>
                              <td class="d-none"><input type="hidden" name="order_id[]" value="{{ $item->order_id }}">{{ $item->order_id }}</td>
                              <td class="d-none"><input type="hidden" name="order_item_id[]" value="{{ $item->order_item_id }}">{{ $item->order_item_id }}</td>
                              <td>{{ $item->brand }}</td>
                              <td>{{ $item->model }}</td>
                              <td>{{ $item->description }}</td>
                              <td>{{ $item->serial_number }}</td>
                              <td><input type="hidden" name="quantity[]" value="{{ $item->order_quantity }}">{{ $item->order_quantity }}</td>
                              <td>
                                <a href="{{ route('remove-borrow', ['id' => $item->order_item_id]) }}" class="btn btn-danger">Remove</a> 
                              </td>
                          </tr>
                          @endif
                                
                        @endforeach
                      </tbody>
                  </table>
                      
                      <div class="row mb-2">
                        <div class="col-sm-6">
                      <input type="date" class="form-control" name="date_returned">
                    </div>
                    <div class="col-sm-6">
                      <button type="submit" class="btn btn-primary" id="btn-already-submit">Submit</button>
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

