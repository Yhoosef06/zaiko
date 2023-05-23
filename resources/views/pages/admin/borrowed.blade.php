@extends('layouts.pages.yields')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Borrowings</h1>
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
                    <h3 class="card-title"><strong>Borrowed Items</strong></h3>
                  </div>
                  <div class="col md-4 text-right">
                    <Button type="submit" class="btn btn-success">Generate Report</Button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="borrowed" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                     <th class="d-none">ID #</th>
                      <th>Serial #</th>
                      <th>Name</th>
                      <th>Item Name</th>
                      <th>Release BY</th>
                      <th>Date Borrowed</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                  
                          @foreach ($borrows as $borrow)
                            <tr>
                            <td class="d-none">{{ $borrow->id }}</td>
                                <td>{{ $borrow->serial_number }}</td>
                                <td>{{ $borrow->first_name }} {{ $borrow->last_name }}</td>
                                <td>{{ $borrow->item_name }}</td>
                                <td>{{ $borrow->release_by }}</td>
                                <td>{{ $borrow->created_at}}</td>
                            
                                <td>
                                
                                  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#returnModal">Return</button>
                                </td>
                            </tr>
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


