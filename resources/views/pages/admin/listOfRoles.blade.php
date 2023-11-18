@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Roles</h1>
                </div>
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addRoomModal">
                            <i class="fa fa-plus"></i> Setup a role & permission
                        </button>
                    </ol> --}}
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
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
                            <table id="listofroles" class="table table-bordered">
                                <label for="">Setup a role and permission:</label>
                                <form action="{{ route('store_permission') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control" name="role_id" id="role_id" required>
                                                <option value="" disabled selected>Select a role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="permission_id" id="permission_id" required>
                                                <option value="" disabled selected>Select a permission</option>
                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn bg-olive">Add</button>
                                        </div>
                                    </div>
                                </form><br>
                                @foreach ($groupedRolePermissions as $roleName => $permissions)
                                    <thead>
                                        <tr>
                                            <th class="text-lg">{{ $roleName }} : permissions</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr data-role-permission-id="{{ $permission['id'] }}">
                                                <td> 
                                                    {{ $permission['name'] }}
                                                </td>
                                                <td>
                                                    <form class="form_delete_btn" method="POST"
                                                        action="{{ route('delete_permission', $permission['id']) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger show-alert-delete-item"
                                                            data-toggle="tooltip"
                                                            title='Delete'onclick="deleteButton('{{ $permission['id'] }}')">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
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
    <script>
        function deleteButton(rolePermissionId) {
            // Remove previous highlighting
            $('#listofroles tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofroles tbody tr[data-role-permission-id="' + rolePermissionId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }
    </script>
@endsection
