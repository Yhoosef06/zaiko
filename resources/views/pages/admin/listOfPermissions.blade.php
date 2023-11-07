@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Permissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addRoomModal">
                            <i class="fa fa-plus"></i> Add a Permission
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
                            <table id="listofrooms" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Permission</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr data-room-id="{{ $permission->id }}">
                                            <td>{{ $permission->id }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                {{-- <button href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-toggle="tooltip" title='Edit' data-target="#editRoomModal"
                                                    data-route="{{ route('edit_room', ['id' => $room->id]) }}"
                                                    onclick="openEditRoomModal({{ $room->id }}, $(this).data('route'))">
                                                    <i class="fa fa-edit"></i>
                                                </button> --}}

                                                <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_room', $permission->id) }}">
                                                    @csrf
                                                    <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger show-alert-delete-item"
                                                        data-toggle="tooltip" title='Delete'
                                                        onclick="deleteButton({{ $permission->id }})"><i
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
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Adding a Room</h5>
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

    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Editing a Room</h5>
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
            $('#addRoomModal').on('show.bs.modal', function(event) {
                var modal = $(this);

                $.get("{{ route('add_room') }}", function(data) {
                    modal.find('.modal-body').html(data);
                });
            });
        });

        function deleteButton(roomId) {
            // Remove previous highlighting
            $('#listofrooms tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofrooms tbody tr[data-room-id="' + roomId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        function openEditRoomModal(roomId, route) {
            var modal = $('#editRoomModal');

            // Remove previous highlighting
            $('#listofrooms tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofrooms tbody tr[data-room-id="' + roomId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Send an AJAX request to fetch the edit view content
            // for the specific college
            $.get(route, {
                room_id: roomId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }
    </script>
@endsection
