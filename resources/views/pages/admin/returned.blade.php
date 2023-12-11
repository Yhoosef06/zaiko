@extends('layouts.pages.yields')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-decoration-underline">Returned</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>


<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           
            <form action="{{ route('download_returned_pdf', ['download' => 'pdf']) }}" method="POST">
              @csrf
              <div class="card">
                <div class="card-header row">
                  <div class="col-sm-6">
                  <div class="form-group">
                    <label>Date range:</label>
  
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                    
                      <input type="text" class="form-control float-right" name="select_date_range" id="reservation" value="{{session('dateRange')}} ">
                      <div class="input-group-append">
                        <span class="input-group-append">
                          <button type="button" id="select-date-range" class="btn btn-success btn-flat">Submit</button>
                        </span>
                      </div>
                    
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>

                
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                 
                  <table id="returned" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th class="d-none">ID #</th>
                      <th>Borrower ID #</th>
                      <th>Serial #</th>
                      <th>Brand</th>
                      <th>Model</th>
                      <th>Release BY</th>
                      <th>Return Date</th>
                      <th>View</th>
                    </tr>
                    </thead>
                    <tbody>
                  
                    @foreach ($forReturns as $forReturn)
                    @php
                    $dateRange = session('dateRange');
                    list($startDate, $endDate) = explode(' - ', $dateRange);
                    $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $startDate);
                    $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $endDate);

                    $dateReturned =\Carbon\Carbon::parse($forReturn->returndate);

                   
                    @endphp 
                    @if ( $dateReturned->between($startDate, $endDate))
                    <tr>
                      <td class="d-none">{{ $forReturn->id }}</td>
                      <td>{{ $forReturn->user_id }}</td>
                      <td>{{ $forReturn->order_serial_number}}</td>
                      <td>{{ $forReturn->brand_name }}</td>
                      <td>{{ $forReturn->model_name }}</td>
                      <td>{{ $forReturn->released_by }}</td>
                      <td>{{ \Carbon\Carbon::parse($forReturn->returndate )->format('F d, Y') }}</td>
                      <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#showReturn{{$forReturn->id}}"><i class="fa fa-eye"></i></button>
                    
                      </td>
                    </tr>

                    <div class="modal fade hide" id="showReturn{{$forReturn->id}}">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title"><span> 
                              {{ $forReturn->last_name }}, {{ $forReturn->first_name }} 
                              </span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Transaction ID: </label>
                                  {{ $forReturn->order_id }}
                                </div>
                              </div>
                              <div class="col-sm-6">
                      
                                <div class="form-group">
                                  <label>Date Return: </label>
                                  {{ $forReturn->date_returned }}
                                </div>
                              
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Category: </label>
                                 
                                            {{ $forReturn->category_name }}
                                     
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Description: </label>
                                 
                                            {{ $forReturn->description }}
                                     
                                </div>
                              </div>
                            

                            </div>

                    

                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Remarks: </label>
                                  {{ $forReturn->remarks }}
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Return To: </label>
                                 {{ $forReturn->returned_to }}
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
                   

                    @endif
                   

                    
                    
                    @endforeach
                    </tbody>
                  
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </form>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
@endsection
