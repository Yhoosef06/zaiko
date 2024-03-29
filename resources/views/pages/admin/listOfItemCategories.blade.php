@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addItemCategoryModal">
                            <i class="fa fa-plus"></i> Add a Item Category
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
                                <table id="listofcategories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categories as $category)
                                            <tr data-category-id="{{ $category->id }}">
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->category_name }}</td>
                                                <td>
                                                    <button href="#" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-toggle="tooltip" title='Edit'
                                                        data-target="#editItemCategoryModal"
                                                        onclick="openEditItemCategoryModal('{{ $category->id }}')">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    @if ($category->items_count == 0)
                                                        <form id="deleteCategory" class="form_delete_btn" method="POST"
                                                            action="{{ route('delete_category', $category->id) }}">
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
                                {{ $categories->links() }}
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

    <div class="modal fade" id="addItemCategoryModal" tabindex="-1" aria-labelledby="addCollegeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCollegeModalLabel">Adding a Item Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addingCategory" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="">Item Category Name:</label>
                        <input type="text" name="category_name" id="category_name"
                            placeholder="Enter a item category name"
                            class="form-control @error('category_name') border-danger @enderror" required>
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

    <div class="modal fade" id="editItemCategoryModal" tabindex="-1" aria-labelledby="addCollegeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCollegeModalLabel">Editing a Item Category</h5>
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
        // $(document).ready(function() {
        //     $('#addingCategory').submit(function(event) {
        //         event.preventDefault();
        //         var formData = new FormData(this);

        //         Swal.fire({
        //             title: 'Adding a Category',
        //             text: 'Do you wish to continue?',
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: '#3085d6',
        //             cancelButtonColor: '#d33',
        //             confirmButtonText: 'Yes'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 $('Button[type="submit"]').prop('disabled', true).html(
        //                     '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Adding...'
        //                 );
        //                 $.ajax({
        //                     url: "{{ route('save_new_category') }}",
        //                     type: "POST",
        //                     data: formData,
        //                     processData: false,
        //                     contentType: false,
        //                     success: function(response) {
        //                         if (response.success) {
        //                             Swal.fire('Success', response.message, 'success')
        //                                 .then(() => {
        //                                     location.reload();
        //                                 });
        //                         } else {
        //                             displayError('An unknown error occurred.');
        //                         }
        //                     },
        //                     error: function(xhr, status, error) {
        //                         var errorResponse = xhr.responseJSON;
        //                         if (errorResponse && errorResponse.error) {
        //                             displayError(errorResponse.error);
        //                         } else {
        //                             displayError(
        //                                 'An error occurred while processing the request'
        //                                 );
        //                         }
        //                     },
        //                 });
        //             }
        //         });
        //     });
        // });

        $(document).ready(function() {
            $('#deleteCategory').submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete this category. This action cannot be undone!',
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
                                    'An error occurred while deleting the category',
                                    'error');
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#addingCategory').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                Swal.fire({
                    title: 'Adding a Category',
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
                            url: "{{ route('save_new_category') }}",
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

        function deleteButton(categoryId) {
            // Remove previous highlighting
            $('#listofcategories tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofcategories tbody tr[data-category-id="' + categoryId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        function openEditItemCategoryModal(categoryId) {
            var modal = $('#editItemCategoryModal');
            var url = "{{ route('edit_item_category', ['id' => ':categoryId']) }}".replace(':categoryId', categoryId);

            // Remove previous highlighting
            $('#listofcategories tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofcategories tbody tr[data-category-id="' + categoryId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            $.get(url, function(data) {
                modal.find('.modal-body').html(data);
            });
        }
    </script>
@endsection
