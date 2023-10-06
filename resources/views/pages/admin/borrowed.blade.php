@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Borrowed</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('borrowItem') }}" class="btn btn-default" >
                            <i class="fa fa-plus"> </i>
                            Add to Borrow
                        </a>
                    </ol>
                </div>
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
                                            <table id="user-pending" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>                                         
                                                        <th>Transaction ID</th>
                                                        <th>Student Name</th>
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
                                                            <a href="{{ route('view-borrow-item', $borrow->transactionId) }}"
                                                                class="btn btn-sm btn-primary" >
                                                                view</a>
                                                        </td>
                                                    </tr>
                                                    
                                                
                                                        
                                                      

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

