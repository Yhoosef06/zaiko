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
           

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Borrowed Items</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Serial #</th>
                    <th>Name</th>
            
                    <th>Item Name</th>
                    <th>Item Description</th>
                    <th>Actions</th>

                  </tr>
                  </thead>
                  <tbody>
                 
                  @foreach ($borrows as $borrow)
                      <tr>
                          <td>{{ $borrow->serial_number }}</td>
                          <td>{{ $borrow->first_name }} {{ $borrow->last_name }}</td>
                          <td>{{ $borrow->item_name }}</td>
                          <td>{{ Str::limit($borrow->item_description, 20, '...') }}</td>
                      
                          <td>
                            <a href="{{ route('borrow_item', $borrow->serial_number) }}" class="btn btn-sm btn-success" title="Approved">
                                    <i class="fa fa-check"></i></a>
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>




    
@endsection
