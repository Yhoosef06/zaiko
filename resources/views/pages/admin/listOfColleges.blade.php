@extends('layouts.pages.yields')

@section('content')
    @php
        use App\Http\Controllers\CollegeController;
    @endphp
    <section class="content-header">
        <div class="container-fluid">
            <div class="text-right">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">Inventory</h1> --}}
                </div>
                {{-- Adding distance from the top navigation bar --}}
                <a href="#" class="btn btn-default" data-toggle="modal" data-target="#addCollegeModal">
                    <i class="fa fa-plus"></i> Add a College
                </a>
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
                            <h3>Colleges</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="listofusers" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>College Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($colleges as $college)
                                        <tr>
                                            <td>{{ $college->id }}</td>
                                            <td>{{ $college->college_name }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-toggle="tooltip" title='Edit' data-target="#editCollegeModal"
                                                    data-route="{{ route('edit_college', ['id' => $college->id]) }}"
                                                    onclick="openEditCollegeModal({{ $college->id }}, $(this).data('route'))">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_college', $college->id) }}">
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
            </div>
        </div>
    </section>

    <div class="modal fade" id="addCollegeModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCollegeModalLabel">Adding a College</h5>
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

    <div class="modal fade" id="editCollegeModal" tabindex="-1" role="dialog" aria-labelledby="editCollegeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCollegeModalLabel">Edit College Information</h5>
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
            $('#addCollegeModal').on('show.bs.modal', function(event) {
                var modal = $(this);

                $.get("{{ route('add_college') }}", function(data) {
                    modal.find('.modal-body').html(data);
                });
            });
        });

        function openEditCollegeModal(collegeId, route) {
            var modal = $('#editCollegeModal');

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Send an AJAX request to fetch the edit view content
            // for the specific college
            $.get(route, {
                college_id: collegeId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }
    </script>
@endsection
