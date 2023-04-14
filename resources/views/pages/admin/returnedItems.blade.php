@extends('layouts.pages.yields')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>RETURNED ITEMS</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>

<section class="content">
    <form action="{{ route('download_pdf', ['download' => 'pdf']) }}" method="POST">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Returned Items</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name Of Borrower</th>
                    <th>Serial #</th>           
                    <th>Item Name</th>
                    <th>Item Description</th>

                  </tr>
                  </thead>
                  <tbody>
                 
                  @foreach ($data as $borrow)
                      <tr>
                        <td>{{ $borrow->first_name }} {{ $borrow->last_name }}</td>
                        <td>{{ $borrow->serial_number }}</td>
                        <td>{{ $borrow->item_name }}</td>
                        <td>{{ Str::limit($borrow->item_description, 20, '...') }}</td>
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
    </form>
    </section>




    
@endsection
