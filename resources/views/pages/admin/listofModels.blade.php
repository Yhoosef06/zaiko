@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Models</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addModelModal">
                            <i class="fa fa-plus"></i> Add a Model
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
                            <table id="listofmodels" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Model Name</th>
                                        <th>Brand</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                        @if ($model->created_at)
                                            @if ($model->created_at->format('Y-m-d H:i:s') == $dateTime->format('Y-m-d H:i:s'))
                                                <tr
                                                    style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); background-color:lightgreen">
                                                    <td>{{ $model->id }}</td>
                                                    <td>{{ $model->model_name }}</td>
                                                    <td>{{ $model->brand->brand_name }}</td>
                                                    <td>
                                                        <button href="#" class="btn btn-sm btn-primary"
                                                            data-toggle="modal" data-toggle="tooltip" title='Edit'
                                                            data-target="#editModelModal"
                                                            data-route="{{ route('edit_model', ['id' => $model->id]) }}"
                                                            onclick="openEditModelModal({{ $model->id }}, $(this).data('route'))">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        @if ($model->items_count == 0)
                                                            <form class="form_delete_btn" method="POST"
                                                                action="{{ route('delete_model', $model->id) }}">
                                                                @csrf
                                                                <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-danger show-alert-delete-item"
                                                                    data-toggle="tooltip" title='Delete'
                                                                    onclick="deleteButton({{ $model->id }})"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                    @foreach ($models as $model)
                                        <tr data-model-id="{{ $model->id }}">
                                            <td>{{ $model->id }}</td>
                                            <td>{{ $model->model_name }}</td>
                                            <td>{{ $model->brand->brand_name }}</td>
                                            <td>
                                                <button href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-toggle="tooltip" title='Edit' data-target="#editModelModal"
                                                    data-route="{{ route('edit_model', ['id' => $model->id]) }}"
                                                    onclick="openEditModelModal({{ $model->id }}, $(this).data('route'))">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                @if ($model->items_count == 0)
                                                    <form class="form_delete_btn" method="POST"
                                                        action="{{ route('delete_model', $model->id) }}">
                                                        @csrf
                                                        <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger show-alert-delete-item"
                                                            data-toggle="tooltip" title='Delete'
                                                            onclick="deleteButton({{ $model->id }})"><i
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

    <div class="modal fade" id="addModelModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModelModalLabel">Adding a Model</h5>
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

    <div class="modal fade" id="editModelModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModelModalLabel">Editing a Model</h5>
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
            $('#addModelModal').on('show.bs.modal', function(event) {
                var modal = $(this);

                $.get("{{ route('add_model') }}", function(data) {
                    modal.find('.modal-body').html(data);
                });
            });
        });

        function deleteButton(modelId) {
            // Remove previous highlighting
            $('#listofmodels tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofmodels tbody tr[data-model-id="' + modelId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        function openEditModelModal(modelId, route) {
            var modal = $('#editModelModal');

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Remove previous highlighting
            $('#listofmodels tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofmodels tbody tr[data-model-id="' + modelId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

            // Send an AJAX request to fetch the edit view content
            // for the specific college
            $.get(route, {
                model_id: modelId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }
    </script>
@endsection
