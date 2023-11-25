@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Roles & Permissions</h1>
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
                            <div id="listofroles">
                                <label for="">Setup role and permissions:</label>
                                <form action="{{ route('store_permission') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control" name="role_id" id="role_id" required>
                                                <option value="" disabled selected>Select a role</option>
                                                @foreach ($roles as $role)
                                                    @if ($role->name != 'admin')
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endif
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
                                            <button type="submit" class="btn bg-olive"
                                                onclick="return confirm('Applying changes.Do you wish to continue?')">Apply</button>
                                        </div>
                                    </div>
                                </form><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="role label" class="text-decoration-underline">Manager:
                                            Permissions</label>
                                        <div class="border border-3 p-2 bg-gray-light">
                                            @forelse ($managerPermissions as $permission)
                                                <div
                                                    class="permission-container d-flex align-items-center justify-content-between border border-1">
                                                    <p>{{ $permission->name }}</p>
                                                    <form class="form_delete_btn" method="POST"
                                                        action="{{ route('delete_permission', $permission->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-default show-alert-delete-item"
                                                            data-toggle="tooltip" title='Delete'
                                                            onclick="deleteButton('{{ $permission->id }}')">Remove</button>
                                                    </form>
                                                </div>
                                            @empty
                                                <p>No assigned permissions.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="role label" class="text-decoration-underline">Borrower:
                                            Permissions</label>
                                        <div class="border border-3 p-2 bg-gray-light">
                                            @forelse ($borrowerPermissions as $permission)
                                                <div
                                                    class="permission-container d-flex align-items-center justify-content-between border border-1">
                                                    <p>{{ $permission->name }}</p>
                                                    <form class="form_delete_btn" method="POST"
                                                        action="{{ route('delete_permission', $permission->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-default show-alert-delete-item"
                                                            data-toggle="tooltip" title='Delete'
                                                            onclick="deleteButton('{{ $permission->id }}')">Remove</button>
                                                    </form>
                                                </div>
                                            @empty
                                                <p>No assigned permissions.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
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
            $('.border-1').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked permission container
            $('.permission-container[data-role-permission-id="' + rolePermissionId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)',
                'background-color': '#A9F5F2'
            });
        }
    </script>
@endsection
