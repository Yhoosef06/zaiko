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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="listofcategories" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        @if ($category->created_at)
                                            @if ($category->created_at->format('Y-m-d H:i:s') == $dateTime->format('Y-m-d H:i:s'))
                                                <tr
                                                    style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); background-color:lightgreen">
                                                    <td>{{ $category->id }}</td>
                                                    <td> {{ $category->category_name }}</td>
                                                    <td>
                                                        <button href="#" class="btn btn-sm btn-primary"
                                                            data-toggle="modal" data-toggle="tooltip" title='Edit'
                                                            data-target="#editItemCategoryModal"
                                                            onclick="openEditItemCategoryModal('{{ $category->id }}')">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        @if ($category->items_count == 0)
                                                            <form class="form_delete_btn" method="POST"
                                                                action="{{ route('delete_category', $category->id) }}">
                                                                @csrf
                                                                <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-danger show-alert-delete-item"
                                                                    data-toggle="tooltip" title='Delete'
                                                                    onclick="deleteButton({{ $category->id }})"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                    @foreach ($categories as $category)
                                        <tr data-category-id="{{ $category->id }}">
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->category_name }}</td>
                                            <td>
                                                <button href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-toggle="tooltip" title='Edit'
                                                    data-target="#editItemCategoryModal"
                                                    onclick="openEditItemCategoryModal('{{ $category->id }}')">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                @if ($category->items_count == 0)
                                                    <form class="form_delete_btn" method="POST"
                                                        action="{{ route('delete_category', $category->id) }}">
                                                        @csrf
                                                        <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger show-alert-delete-item"
                                                            data-toggle="tooltip" title='Delete'
                                                            onclick="deleteButton({{ $category->id }})"><i
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
                    <!-- Content will be loaded here -->
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
        $(document).ready(function() {
            $('#addItemCategoryModal').on('show.bs.modal', function(event) {
                var modal = $(this);

                $.get("{{ route('add_item_category') }}", function(data) {
                    modal.find('.modal-body').html(data);
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
