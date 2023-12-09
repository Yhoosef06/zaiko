@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Brands</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addBrandModal">
                            <i class="fa fa-plus"></i> Add a Brand
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
                                <div class="search-bar mb-2 float-md-right">
                                    <form action="{{ route('brands.search') }}" method="GET">
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
                                <table id="listofbrands" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Brand Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($brands as $brand)
                                            <tr data-brand-id="{{ $brand->id }}">
                                                <td>{{ $brand->id }}</td>
                                                <td>{{ $brand->brand_name }}</td>
                                                <td>
                                                    <button href="#" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-toggle="tooltip" title='Edit'
                                                        data-target="#editBrandModal"
                                                        data-route="{{ route('edit_brand', ['id' => $brand->id]) }}"
                                                        onclick="openEditBrandModal({{ $brand->id }}, $(this).data('route'))">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    @if ($brand->models_count == 0)
                                                        <form id="deleteBrand" class="form_delete_btn" method="POST"
                                                            action="{{ route('delete_brand', $brand->id) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger show-alert-delete-item"
                                                                data-toggle="tooltip" title='Delete'>
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
                                {{ $brands->links() }}
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

    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">Adding a Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addingBrand" action="{{ route('save_new_brand') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label for="">Brand Name:</label>
                        <input type="text" name="brand_name" id="brand_name" placeholder="Enter a brand name"
                            class="form-control @error('brand_name') border-danger @enderror" required>
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

    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="addCollegeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBrandModalLabel">Editing a Brand</h5>
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
    <script>
        $(document).ready(function() {
            $('#deleteBrand').submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete this brand. This action cannot be undone!',
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
                            data: $(this).serialize(),
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
                                    'An error occurred while deleting the brand',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
        
        $(document).ready(function() {
            $('#addingBrand').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                Swal.fire({
                    title: 'Adding a Brand',
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
                            url: $(this).attr('action'),
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
                                    Swal.fire('Error', errorMessage, 'error').then(
                                        () => {
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

        function deleteButton(brandId) {
            // Remove previous highlighting
            $('#listofbrands tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofbrands tbody tr[data-brand-id="' + brandId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        function openEditBrandModal(brandId, route) {
            var modal = $('#editBrandModal');

            // Remove previous highlighting
            $('#listofbrands tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofbrands tbody tr[data-brand-id="' + brandId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Send an AJAX request to fetch the edit view content
            // for the specific college
            $.get(route, {
                brand_id: brandId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }
    </script>
@endsection
