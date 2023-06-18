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
                    <div class="card-body table-responsive p-0" style="height: 250px;">
                      <table class="table table-head-fixed text-nowrap" id="notAdded">
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
                    <div class="card-body table-responsive p-0" style="height: 250px;">
                    <form method="POST">
                  
                      <table class="table table-head-fixed text-nowrap" id="alreadyAdded">
                        <thead>
                          <tr>
                                <th  class="d-none">ID</th>
                                <th style="background-color:#28a745; color:aliceblue">Brand</th>
                                <th style="background-color:#28a745; color:aliceblue">Model</th>
                                <th style="background-color:#28a745; color:aliceblue">Description</th>
                                <th style="background-color:#28a745; color:aliceblue">Serial</th>
                                <th style="background-color:#28a745; color:aliceblue">Quantity</th>
                                <th style="background-color:#28a745; color:aliceblue">Option</th>
                               
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item)
                            @if ($item->category_name === 'Tools')
                                <tr>
                                    <td class="d-none">{{ $item->order_item_id }}</td>
                                    <td>{{ $item->brand }}</td>
                                    <td>{{ $item->model }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->serial_number }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td> 
                                    
                                        <a href="" class="btn btn-danger">Remove</a> 
                                      </td>
                                </tr>
                            @else
                                @for ($i = 1; $i <= $item->quantity; $i++)
                                    <tr>
                                        <td class="d-none">{{ $item->order_item_id }}</td>
                                        <td>{{ $item->brand }}</td>
                                        <td>{{ $item->model }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td> <input type="text" name="user_serial_number" class="form-control search_for_serial"></td>
                                        <td>1</td>
                                        <td> 
                                            <a href="" class="btn btn-danger">Remove</a> 
                                          </td>
                                    </tr>
                                @endfor
                            @endif
                        @endforeach
                    
                          
                      
                        </tbody>
                      </table>
                      <button type="submit" class="btn btn-primary">Submit</button>
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

