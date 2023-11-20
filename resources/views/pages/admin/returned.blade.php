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
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="returned" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th class="d-none">ID #</th>
                      <th>ID Number</th>
                      <th>Serial #</th>
                      <th>Brand</th>
                      <th>Release BY</th>
                      <th>Return Date</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                  
                    @foreach ($forReturns as $forReturn)
                    <tr>
                      <td class="d-none">{{ $forReturn->id }}</td>
                      <td>{{ $forReturn->user_id }}</td>
                      <td>{{ $forReturn->order_serial_number}}</td>
                      <td>{{ $forReturn->brand_name }}</td>
                      <td>{{ $forReturn->released_by }}</td>
                      <td>{{ $forReturn->returndate }}</td>
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
                                  <label>ID Number: </label>
                                  {{ $forReturn->user_id }}
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
                                  <label>Brand: </label>
                                 {{ $forReturn->brand_name }}
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Model: </label>
                                  {{ $forReturn->model_name }}
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Serial Number: </label>
                                 {{ $forReturn->order_serial_number }}
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
                                  <label>Return TO: </label>
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
