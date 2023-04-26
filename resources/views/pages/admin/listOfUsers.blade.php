@extends('layouts.pages.yields')

@section('content')

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Users</h1>
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
                <h3 class="card-title"><strong>List of All Users</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="listofusers" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID #</th>
                    <th>Name</th>
                    <th>Account Type</th>
                    <th>Account Status</th>
                    <th>Actions</th>

                  </tr>
                  </thead>
                  <tbody>
                 
                  @foreach ($users as $user)
                      <tr>
                          <td>{{ $user->id_number }}</td>
                          <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                          @if ($user->account_type == 'student')
                                <td>{{ 'Student' }}</td>
                            @elseif ($user->account_type == 'admin')
                                <td>{{ 'Admin' }}</td>
                            @else
                                <td>{{ 'READS' }}</td>
                            @endif
                            @if ($user->account_status == 'pending')
                                <td><span class="bg-warning p-1 m-1" style="padding:10px">{{ 'Pending' }}</span>
                                </td>
                            @else
                                <td><span class="bg-success p-1 m-1" style="padding:10px">{{ 'Approved' }}</span>
                                </td>
                            @endif
                      
                          <td><a href="{{ route('view_user_info', $user->id_number) }}" class="btn btn-sm btn-primary">
                                  <i class="fa fa-eye"></i></a>
                              <a href="{{ route('edit_user_info', $user->id_number) }}" class="btn btn-sm btn-warning">
                                  <i class="fa fa-edit"></i></a>

                              <!-- Button to Open the Modal -->
                              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#myModal">
                                    <i class="fa fa-trash"></i>
                                </button>

                              <!-- The Modal -->
                              <div class="modal" id="myModal">
                                  <div class="modal-dialog">
                                      <div class="modal-content">

                                          <!-- Modal Header -->
                                          <div class="modal-header">
                                              <h4 class="modal-title">Deleting User</h4>
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>

                                          <!-- Modal body -->
                                          <div class="modal-body">
                                              Are you sure you want to delete user?
                                          </div>

                                          <!-- Modal footer -->
                                          <div class="modal-footer">
                                                <form action="{{ route('delete_user', $user->id_number) }}" method="POST"
                                                    class="form-check-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">Confirm</button>
                                                </form>
                                            </div>

                                      </div>
                                  </div>
                              </div>

                          </td>
                      </tr>
                  @endforeach
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
