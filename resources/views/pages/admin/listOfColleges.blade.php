@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Colleges</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addCollegeModal">
                            <i class="fa fa-plus"></i> Add a College
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
                                <table id="listofcolleges" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>College Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($colleges as $college)
                                            <tr data-college-id="{{ $college->id }}">
                                                <td>{{ $college->id }}</td>
                                                <td>{{ $college->college_name }}</td>
                                                <td>
                                                    <button href="#" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-toggle="tooltip" title='Edit'
                                                        data-target="#editCollegeModal"
                                                        data-route="{{ route('edit_college', ['id' => $college->id]) }}"
                                                        onclick="openEditCollegeModal({{ $college->id }}, $(this).data('route'))">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    @if ($college->departments_count == 0)
                                                        {{-- <form class="form_delete_btn" method="POST"
                                                            action="{{ route('delete_college', $college->id) }}">
                                                            @csrf
                                                            <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger show-alert-delete-item"
                                                                data-toggle="tooltip" title='Delete'
                                                                onclick="deleteButton({{ $college->id }})"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form> --}}
                                                        <form id="deleteCollege" class="form_delete_btn" method="POST"
                                                            action="{{ route('delete_college', $college->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="college_id"
                                                                value="{{ $college->id }}">
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
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
                                {{ $colleges->links() }}
                            </div>
                        </div>
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
                    {{-- <form class="form-signin" action="{{ route('save_new_college') }}" method="POST"
                    enctype="multipart/form-data"> --}}
                    <form id="addingCollege" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="">College Name:</label>
                        <input type="text" name="college_name" id="college_name" placeholder="Enter a college name"
                            class="form-control @error('college_name') border-danger @enderror" required>
                        <hr>
                        <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                        <Button type="submit" class="btn btn-success">Save</Button>
                    </form>
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
            $('#deleteCollege').submit(function(event) {
                event.preventDefault();
                var termId = $(this).find('input[name="college_id"]').val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete this School. This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(this).attr('action'),
                            type: $(this).attr('method'),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.message, 'success')
                                        .then(() => {
                                            location
                                                .reload(); // Reload the page after successful deletion
                                        });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error!',
                                    'An error occurred while deleting the term',
                                    'error');
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#addingCollege').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                Swal.fire({
                    title: 'Adding a College.',
                    text: 'Do you wish to continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('button[type="submit"]').prop('disabled', true).html(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Adding...'
                        );
                        $.ajax({
                            url: "{{ route('save_new_college') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Success', response.message, 'success')
                                        .then(() => {
                                            location.reload();
                                        });
                                } else {
                                    displayError('An unknown error occurred.');
                                }
                            },
                            error: function(xhr, status, error) {
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    var errors = xhr.responseJSON.errors;
                                    var errorMessage = Object.values(errors).flat()
                                        .join('<br>');
                                    Swal.fire('Error', errorMessage, 'error').then(() => {
                                location.reload();
                            });
                                } else {
                                    displayError(
                                        'An error occurred while processing the request'
                                        );
                                }
                            },
                        });
                    }
                });
            });
        });

        function deleteButton(collegeId) {
            // Remove previous highlighting
            $('#listofcolleges tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofcolleges tbody tr[data-college-id="' + collegeId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        function openEditCollegeModal(collegeId, route) {
            var modal = $('#editCollegeModal');

            // Remove previous highlighting
            $('#listofcolleges tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofcolleges tbody tr[data-college-id="' + collegeId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

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
