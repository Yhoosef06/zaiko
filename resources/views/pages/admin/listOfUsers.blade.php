@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Manage Users</h1>
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
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Department</th>
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
                                            @elseif($user->account_type == 'faculty')
                                                <td>{{ 'Faculty' }}</td>
                                            @else
                                                <td>{{ 'READS' }}</td>
                                            @endif

                                            @if ($user->account_type == 'student')
                                                @if ($user->account_status == 'pending')
                                                    <td><span class="bg-warning p-1 m-1"
                                                            style="padding:10px">{{ 'Pending' }}</span>
                                                    </td>
                                                @else
                                                    <td><span class="bg-success p-1 m-1"
                                                            style="padding:10px">{{ 'Approved' }}</span>
                                                    </td>
                                                @endif
                                            @else
                                                <td><span class="bg-success p-1 m-1"
                                                        style="padding:10px">{{ 'Approved' }}</span>
                                                </td>
                                            @endif

                                            <td>{{ $user->departments->department_name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-item-details"
                                                    onclick="openItemModal('{{ $user->id_number }}')">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                <a href="#"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-cart-plus"></i></a>

                                                <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_user', $user->id_number) }}">
                                                    @csrf
                                                    <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger show-alert-delete-item"
                                                        data-toggle="tooltip" title='Delete'><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
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


    <!-- Modal -->
    <div class="modal fade" id="modal-item-details" tabindex="-1" role="dialog"
        aria-labelledby="modal-item-details-label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-item-details-label">User Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    <a href="{{ route('edit_user_info', ['id_number' => $user->id_number]) }}"
                        class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function openItemModal(userId) {
        // Send an AJAX request to fetch the item details
        $.ajax({
            url: 'view-user-' + userId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                // Populate the modal window with the item details
                $('#modal-item-details .modal-body').html(
                    '<p><strong>I.D. #:</strong> ' + data.id_number + '</p>' +
                    '<p><strong>First Name:</strong> ' + data.first_name + '</p>' +
                    '<p><strong>Last Name:</strong> ' + data.last_name + '</p>' +
                    '<p><strong>Account Type:</strong> ' + data.account_type + '</p>' +
                    '<p><strong>Account Status:</strong> ' + data.account_status + '</p>' +
                    '<p><strong>Department ID:</strong> ' + data.departments.department_name + '</p>'
                );
                // Update the "Edit" button link with the correct item ID
                var editUrl = '{{ route('edit_user_info', ['id_number' => ':userId']) }}';
                editUrl = editUrl.replace(':userId', data.id_number);
                $('#modal-item-details .modal-footer a').attr('href', editUrl);
            },
            error: function(xhr, status, error) {
                // Display an error message if the AJAX request fails
                $('#modal-item-details .modal-body').html(
                    '<p>Failed to load item details.</p>' +
                    '<p>Error: ' + error + '</p>'
                );
            }
        });

        // Show the modal window
        $('#modal-item-details').modal('hide');
    }
</script>
