@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Departments</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addDepartmentModal">
                            <i class="fa fa-plus"></i> Add a Department/Program
                        </button>
                    </ol>
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
                            <div class="table-responsive">
                                @if (Auth::user()->roles->contains('name', 'admin'))
                                    <div class="ml-1 float-md-right">
                                        <button name="searchFilter" class="btn bg-yellow" data-toggle="modal"
                                            data-target="#filterModal" data-toggle="tooltip" title="Filter Users"><i
                                                class="fa fa-filter"></i></button>
                                    </div>
                                @endif

                                <div class="search-bar mb-2 float-md-right">
                                    <form action="{{ route('departments.search') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search..." value="{{ old('search', request('search')) }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn bg-yellow" data-toggle="tooltip"
                                                    title="Search">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <table id="listofdepartments" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Departments/Programs Name</th>
                                            <th>College</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($departments as $department)
                                            <tr data-department-id="{{ $department->id }}">
                                                <td>{{ $department->id }}</td>
                                                <td>{{ $department->department_name }}</td>
                                                <td>{{ $department->college->college_name }}</td>
                                                <td>
                                                    <button href="#" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-toggle="tooltip" title='Edit'
                                                        data-target="#editDepartmentModal"
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
                                                                data-toggle="tooltip" title='Delete'
                                                                onclick="deleteButton({{ $department->id }})"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center bg-white">No available data.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-md-right">
                                {{ $departments->links() }}
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
                    <h5 class="modal-title" id="editDepartmentModalLabel">Edit Department Information</h5>
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

    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter By School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" method="GET" action="{{ route('get_filtered_departments') }}">
                    <div class="modal-body" style="max-height: 200px; overflow-y: auto;">
                        <div class="row">
                            <div class="">
                                <label for="collegeFilter">Filter By Schools:</label>
                                <div>
                                    @foreach ($colleges as $college)
                                        <div>
                                            <input type="checkbox" name="college_ids[]" value="{{ $college->id }}">
                                            {{ $college->college_name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-olive" id="applyFilter">Apply</button>
                        <a href="#" type="button" id="clearFilters">Clear</a>
                    </div>
                </form>
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

        function deleteButton(departmentId) {
            // Remove previous highlighting
            $('#listofdepartments tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofdepartments tbody tr[data-department-id="' + departmentId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        function openEditDepartmentModal(departmentId, route) {
            var modal = $('#editDepartmentModal');

            // Remove previous highlighting
            $('#listofdepartments tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofdepartments tbody tr[data-department-id="' + departmentId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

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

        $(document).ready(function() {
            $('#clearFilters').click(function() {
                $('input[name^="college_ids[]"]').prop('checked', false);
            });
        });
    </script>
@endsection
