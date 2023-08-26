@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="text-right">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">Inventory</h1> --}}
                </div>
                {{-- Adding distance from the top navigation bar --}}
                <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addTermModal">
                    <i class="fa fa-plus"></i> Add a Term
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
                            <h3>Models</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="listofitems" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Semester</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>isCurrent</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($terms as $term)
                                        <tr>
                                            <td>{{ $term->id }}</td>
                                            <td>{{ $term->semester }}</td>
                                            <td>{{ $term->start_date }}</td>
                                            <td>{{ $term->end_date }}</td>
                                            <td>
                                                @if ($term->isCurrent == 0)
                                                    <input class="size-32" type="checkbox" name="isCurrent" id="isCurrent">
                                                @else
                                                    <input class="size-32 active" type="checkbox" name="isCurrent" id="isCurrent">
                                                @endif
                                            </td>
                                            <td>
                                                {{-- <button href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-toggle="tooltip" title='Edit' data-target="#editBrandModal"
                                                    data-route="{{ route('edit_brand', ['id' => $brand->id]) }}"
                                                    onclick="openEditBrandModal({{ $brand->id }}, $(this).data('route'))">
                                                    <i class="fa fa-edit"></i>
                                                </button> --}}
                                                {{-- @if ($brand->models_count == 0) --}}
                                                <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_term', $term->id) }}">
                                                    @csrf
                                                    <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger show-alert-delete-item"
                                                        data-toggle="tooltip" title='Delete'><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                                {{-- @endif --}}
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

    <div class="modal fade" id="addTermModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTermModalLabel">Adding a Term</h5>
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

    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
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
            $('#addTermModal').on('show.bs.modal', function(event) {
                var modal = $(this);

                $.get("{{ route('add_term') }}", function(data) {
                    modal.find('.modal-body').html(data);
                });
            });
        });

        // function openEditBrandModal(brandId, route) {
        //     var modal = $('#editBrandModal');

        //     // Clear previous content from the modal
        //     modal.find('.modal-body').html('');

        //     // Send an AJAX request to fetch the edit view content
        //     // for the specific college
        //     $.get(route, {
        //         brand_id: brandId
        //     }, function(data) {
        //         modal.find('.modal-body').html(data);
        //     });
        // }
    </script>
@endsection
