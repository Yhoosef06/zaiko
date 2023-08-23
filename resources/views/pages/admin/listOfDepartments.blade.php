@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="text-right">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">Inventory</h1> --}}
                </div>
                {{-- Adding distance from the top navigation bar --}}
                <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addDepartmentModal">
                    <i class="fa fa-plus"></i> Add a Department/Program
                </button>
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
                            <h3>Departments/Programs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="listofitems" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Departments/Programs Name</th>
                                        <th>College</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $department)
                                        <tr>
                                            <td>{{ $department->id }}</td>
                                            <td>{{ $department->department_name }}</td>
                                            <td>{{ $department->college->college_name }}</td>
                                            <td>
                                                <button href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-toggle="tooltip" title='Edit' data-target="#editDepartmentModal"
                                                    data-route="{{ route('edit_department', ['id' => $department->id]) }}"
                                                    onclick="openEditDepartmentModal({{ $department->id }}, $(this).data('route'))">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                @if ($department->users_count == 0)
                                                <form class="form_delete_btn" method="POST"
                                                action="{{ route('delete_department', $department->id) }}">
                                                @csrf
                                                <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger show-alert-delete-item"
                                                    data-toggle="tooltip" title='Delete'><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                                @endif
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

    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addCollegeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCollegeModalLabel">Adding a Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editCollegeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDepartmentModalLabel">Edit Department/Program Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- This is where the content of the edit form will be loaded -->
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#addDepartmentModal').on('show.bs.modal', function(event) {
                var modal = $(this);

                $.get("{{ route('add_department') }}", function(data) {
                    modal.find('.modal-body').html(data);
                });
            });
        });

        function openEditDepartmentModal(departmentId, route) {
            var modal = $('#editDepartmentModal');

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Send an AJAX request to fetch the edit view content
            // for the specific college
            $.get(route, {
                department_id: departmentId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }
    </script>
@endsection
