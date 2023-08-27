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

                            <h3>School Years</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="listofterms" class="table table-bordered table-striped">
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
                                        <tr data-term-id="{{ $term->id }}">
                                            <td>{{ $term->id }}</td>
                                            <td>{{ $term->semester }}</td>
                                            <td>{{ $term->start_date }}</td>
                                            <td>{{ $term->end_date }}</td>
                                            <td>
                                                @if ($term->isCurrent == 0)
                                                    <input class="size-32" type="checkbox" name="isCurrent" id="isCurrent">
                                                @else
                                                    <input class="size-32 active" type="checkbox" name="isCurrent"
                                                        id="isCurrent">
                                                @endif
                                            </td>
                                            <td>
                                                {{-- @if ($brand->models_count == 0) --}}
                                                <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_term', $term->id) }}">
                                                    @csrf
                                                    <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger show-alert-delete-item"
                                                        data-toggle="tooltip" title='Delete'
                                                        onclick="deleteButton({{ $term->id }})"><i
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
@endsection

<script>
    $(document).ready(function() {
        $('#addTermModal').on('show.bs.modal', function(event) {
            var modal = $(this);

            $.get("{{ route('add_term') }}", function(data) {
                modal.find('.modal-body').html(data);
            });
        });
    });

    function deleteButton(termId) {
        // Remove previous highlighting
        $('#listofterms tbody tr').css({
            'box-shadow': 'none',
            'background-color': 'transparent'
        });

        // Add the highlighted class to the clicked row
        $('#listofterms tbody tr[data-term-id="' + termId + '"]').css({
            'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
            'background-color': '#A9F5F2' // Adjust the color as needed
        });
    }
</script>
