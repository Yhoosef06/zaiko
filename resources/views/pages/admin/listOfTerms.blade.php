@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Terms</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addTermModal">
                            <i class="fa fa-plus"></i> Add a Term
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
                            <div class=" table-responsive">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                                    </div>
                                @elseif (session('danger'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                                    </div>
                                @endif
                                <table id="listofusers"
                                    class="table table-bordered table-hover dataTable dtr-inline collapsed">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Semester</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Current</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($terms as $term)
                                            <tr data-term-id="{{ $term->id }}">
                                                <td>{{ $term->id }}</td>
                                                <td>{{ $term->semester }}</td>
                                                <td>{{ date('F j, Y', strtotime($term->start_date)) }}</td>
                                                <td>{{ date('F j, Y', strtotime($term->end_date)) }}</td>
                                                <td>
                                                    <input class="size-32 checkbox-toggle" type="checkbox"
                                                        name="currentTerm" id="currentTerm{{ $term->id }}"
                                                        data-term-id="{{ $term->id }}"
                                                        {{ $term->isCurrent || $term->id == $currentTermId ? 'checked' : '' }}
                                                        onclick="return confirm('Do you wish to continue changing current term?')">
                                                </td>
                                                <td>
                                                    @if ($term->id != $currentTermId)
                                                        <form class="form_delete_btn" method="POST"
                                                            action="{{ route('delete_term', $term->id) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger show-alert-delete-item"
                                                                data-toggle="tooltip" title='Delete'
                                                                onclick="deleteButton({{ $term->id }})"><i
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

    <!-- Modal -->
    <div class="modal fade" id="addTermModal" tabindex="-1" aria-labelledby="addTermModalLabel" aria-hidden="true">
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
            $('#listofusers tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofusers tbody tr[data-term-id="' + termId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        $(document).ready(function() {
            // Add an event listener to the checkboxes
            $('.checkbox-toggle').change(function() {
                // Find the closest row
                var row = $(this).closest('tr');

                // Find the term ID of the clicked checkbox
                var termId = row.find('.checkbox-toggle').data('term-id');

                // Update the hidden field with the current term ID
                $('#currentTermId').val(termId);

                // Make an AJAX request to update the current term in the database
                $.ajax({
                    type: 'POST',
                    url: '{{ route('current_term', ['id' => 'currentTermId']) }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        termId: termId
                    },
                    success: function(data) {
                        // Handle the success response if needed
                        // Uncheck all checkboxes except the current one
                        $('.checkbox-toggle').prop('checked', false);
                        row.find('.checkbox-toggle').prop('checked', true);

                        // Show the delete button for all rows where the checkbox is unchecked
                        $('.btn-danger').show();
                        // Hide the delete button for the current row where the checkbox is checked
                        row.find('.btn-danger').hide();

                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error if needed
                    }
                });
            });
        });
    </script>
@endsection
