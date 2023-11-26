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

                                {{-- <div class="ml-1 float-md-right">
                                <a href="#" class="btn bg-yellow" data-toggle="tooltip"
                                    title="Sort By Row # (Ascending)">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>

                            <div class="ml-1 float-md-right">
                                <a href="#" class="btn bg-yellow " data-toggle="tooltip"
                                    title="Sort By Row # (Descending)">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                            </div> --}}

                                <div class="search-bar mb-2 float-md-right">
                                    <form action="{{ route('models.search') }}" method="GET">
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
                                        @forelse ($models as $model)
                                            <tr data-model-id="{{ $model->id }}">
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
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center bg-white">No available data.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-md-right">
                                {{ $models->links() }}
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
                 
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter By Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" method="GET" action="{{ route('get_filtered_models') }}">
                    <div class="modal-body" style="max-height: 200px; overflow-y: auto;">
                        <div class="row">
                            <div class="">
                                <label for="brandFilter">Brand:</label>
                                <div>
                                    @foreach ($brands as $brand)
                                        <input type="checkbox" name="brand_ids[]" value="{{ $brand->id }}"
                                            @if (in_array($brand->id, request('brand_ids', []))) checked @endif>
                                        {{ $brand->brand_name }}<br>
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
            $('#addModelModal').on('show.bs.modal', function(event) {
                var modal = $(this);

                $.get("{{ route('add_model') }}", function(data) {
                    modal.find('.modal-body').html(data);
                });
            });
        });

        function deleteButton(modelId) {
            
            $('#listofmodels tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

          
            $('#listofmodels tbody tr[data-model-id="' + modelId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', 
                'background-color': '#A9F5F2' 
            });
        }

        function openEditModelModal(modelId, route) {
            var modal = $('#editModelModal');

            modal.find('.modal-body').html('');

            $('#listofmodels tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });


            $('#listofmodels tbody tr[data-model-id="' + modelId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', 
                'background-color': '#A9F5F2' 
            });

            $.get(route, {
                model_id: modelId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }

        $(document).ready(function() {
            $('#clearFilters').click(function() {
                $('input[name^="brand_ids[]"]').prop('checked', false);
            });
        });
    </script>
@endsection
