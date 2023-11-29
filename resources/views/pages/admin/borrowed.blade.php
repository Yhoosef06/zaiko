@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Borrowed</h1>
                </div>
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('borrowItem') }}" class="btn btn-default" >
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
                                            <table id="released-table" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>                                         
                                                        <th>Transaction ID</th>
                                                        <th>Borrower Name</th>
                                                        <th>Date Borrowed</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($borrows as $borrow)

                                          
                                                    <tr>
                                                        <td>{{ $borrow->transactionId }}</td>
                                                        <td>
                                                            {{ $borrow->first_name }} {{ $borrow->last_name }}
                                                        </td>
                                                       
                                                        <td> {{ \Carbon\Carbon::parse($borrow->date_submitted)->format('F d, Y') }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary" id="btn-return-overdue"  data-toggle="modal" data-target="#viewOrder{{$borrow->transactionId}}">View</button>
                                                            {{-- <a href="{{ route('view-borrow-item', $borrow->transactionId) }}"
                                                                class="btn btn-sm btn-primary" >
                                                                view</a> --}}
                                                        </td>
                                                    </tr>


                                                    
                    <div class="modal fade hide" id="viewOrder{{$borrow->transactionId}}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"><strong>Transaction:</strong> {{ $borrow->transactionId }}</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                                <div class="card-body table-responsive p-0" style="height: 300px;">

                                    <div class="card">
                                       
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                          <ul class="products-list product-list-in-card pl-2 pr-2">
                                            @foreach ( $viewBorrows as $viewBorrow )
                                            @if ($borrow->transactionId === $viewBorrow->order_id)
                                            <li class="item">
                                                <div class="product-img">
                                                    @if ($viewBorrow->item_image == null)
                                                    <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                                            @else
                                                                <img src="{{ asset('storage/' . $viewBorrow->item_image) }}"
                                                                alt="Product Image" class="img-size-50">
                                                            @endif
                                                 
                                                </div>
                                                <div class="product-info">
                                                  <a href="javascript:void(0)" class="product-title">{{$viewBorrow->brand}}
                                                    <span class="badge badge-success float-right"><strong>QTY: </strong> {{ $viewBorrow->order_quantity}}</span></a>
                                                  <span class="product-description">
                                                    {{ $viewBorrow->description}}
                                                  </span>
                                                </div>
                                              </li>
                                                
                                            @endif
                                          
                                                
                                            @endforeach
                                            
                                        
                                            <!-- /.item -->
                                          </ul>
                                        </div>
                                        <!-- /.card-body -->
                                      
                                        <!-- /.card-footer -->
                                      </div>
                                    
                                </div>
                           
                              
                  

                               
                                   
                                   
                            
                      
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <a href="{{ route('view-borrow-item', $borrow->transactionId) }}"
                                class="btn btn-success" >
                                Proceed</a>
                              
                            </div>
                        
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

