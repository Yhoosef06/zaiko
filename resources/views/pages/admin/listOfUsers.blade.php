@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="text-right">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">Inventory</h1> --}}
                </div>
                {{-- Adding distance from the top navigation bar --}}
                {{-- <a href="{{ route('add_user') }}" class="btn btn-default"> <i class="fa fa-plus"></i> Create Account</a> --}}
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                                </div>
                            @elseif (session('danger'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                                </div>
                            @endif

                            <h3>{{ Auth::user()->account_type == 'faculty' ? 'Students' : 'Users' }}</h3>
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
                                        @if ($user->id_number != Auth::user()->id_number)
                                            <tr data-user-id="{{ $user->id_number }}">
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

                                                @if ($user->account_status == 'pending')
                                                    <td><span class="bg-warning p-1 m-1"
                                                            style="padding:10px">{{ 'Pending' }}</span>
                                                    </td>
                                                @else
                                                    <td><span class="bg-success p-1 m-1"
                                                            style="padding:10px">{{ 'Approved' }}</span>
                                                    </td>
                                                @endif
                                                <td>{{ $user->departments->department_name }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#modal-user-info" data-toggle="tooltip" title='View'
                                                        onclick="openViewUserModal('{{ $user->id_number }}')">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    <form class="form_delete_btn" method="POST"
                                                        action="{{ route('delete_user', $user->id_number) }}">
                                                        @csrf
                                                        <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger show-alert-delete-item"
                                                            data-toggle="tooltip" title='Delete'
                                                            onclick="deleteButton({{ $user->id_number }})"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    <!-- Modal -->
    {{-- <div class="modal fade" id="modal-user-information" tabindex="-1" role="dialog"
        aria-labelledby="modal-user-information">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-user-information">User Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ml-2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    <a data-toggle="modal" data-target="#modal-edit-user-info" onclick="openEditUserModal()"
                        class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="modal-user-info" tabindex="-1" role="dialog" aria-labelledby="modal-user-info">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-user-info">
                        {{ Auth::user()->account_type == 'faculty' ? 'Student' : 'User' }} Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function deleteButton(userId) {
        // Remove previous highlighting
        $('#listofusers tbody tr').css({
            'box-shadow': 'none',
            'background-color': 'transparent'
        });

        // Add the highlighted class to the clicked row
        $('#listofusers tbody tr[data-user-id="' + userId + '"]').css({
            'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
            'background-color': '#A9F5F2' // Adjust the color as needed
        });
    }

    function openViewUserModal(userId) {
        var modal = $('#modal-user-info');
        var url = "{{ route('view_user_info', ['id_number' => ':userId']) }}".replace(':userId', userId);
        // Clear previous content from the modal
        modal.find('.modal-body').html('');

        // Remove previous highlighting
        $('#listofusers tbody tr').css({
            'box-shadow': 'none',
            'background-color': 'transparent'
        });

        // Add the highlighted class to the clicked row
        $('#listofusers tbody tr[data-user-id="' + userId + '"]').css({
            'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
            'background-color': '#A9F5F2' // Adjust the color as needed
        });


        $.get(url, function(data) {
            modal.find('.modal-body').html(data);
        });
    }
</script>
