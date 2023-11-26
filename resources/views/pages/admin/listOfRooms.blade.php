@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Rooms</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button href="#" class="btn btn-default" data-toggle="modal" data-target="#addRoomModal">
                            <i class="fa fa-plus"></i> Add a Room
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

                                <div class="search-bar mb-2 float-md-right">
                                    <form action="{{ route('rooms.search') }}" method="GET">
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
                                <table id="listofrooms" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Room Name</th>
                                            <th>Departments</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($rooms as $room)
                                            <tr data-room-id="{{ $room->id }}">
                                                <td>{{ $room->id }}</td>
                                                <td>{{ $room->room_name }}</td>
                                                <td>{{ $room->department->department_name }}</td>
                                                <td>
                                                    <button href="#" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-toggle="tooltip" title='Edit'
                                                        data-target="#editRoomModal"
                                                        data-route="{{ route('edit_room', ['id' => $room->id]) }}"
                                                        onclick="openEditRoomModal({{ $room->id }}, $(this).data('route'))">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    @if ($room->items_count == 0)
                                                        <form class="form_delete_btn" method="POST"
                                                            action="{{ route('delete_room', $room->id) }}">
                                                            @csrf
                                                            <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger show-alert-delete-item"
                                                                data-toggle="tooltip" title='Delete'
                                                                onclick="deleteButton({{ $room->id }})"><i
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
                                {{ $rooms->links() }}
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

    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter By Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" method="GET" action="{{ route('get_filtered_rooms') }}">
                    <div class="modal-body" style="max-height: 200px; overflow-y: auto;">
                        <div class="row">
                            <div class="">
                                <label for="departmentFilter">Filter By Departments:</label>
                                <div>
                                    @foreach ($colleges as $college)
                                    <strong>{{ $college->college_name }}</strong><br>
                                    @foreach ($college->departments as $department)
                                        <input type="checkbox" name="department_ids[]" value="{{ $department->id }}"
                                            @if (in_array($department->id, request('department_ids', []))) checked @endif>
                                        {{ $department->department_name }}<br>
                                    @endforeach
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
            $('#addRoomModal').on('show.bs.modal', function(event) {
                var modal = $(this);

                $.get("{{ route('add_room') }}", function(data) {
                    modal.find('.modal-body').html(data);
                });
            });
        });

        function deleteButton(roomId) {
            $('#listofrooms tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

         
            $('#listofrooms tbody tr[data-room-id="' + roomId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', 
                'background-color': '#A9F5F2' 
            });
        }

        function openEditRoomModal(roomId, route) {
            var modal = $('#editRoomModal');

            $('#listofrooms tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            $('#listofrooms tbody tr[data-room-id="' + roomId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)',
                'background-color': '#A9F5F2' 
            });

            modal.find('.modal-body').html('');

            $.get(route, {
                room_id: roomId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }

        $(document).ready(function() {
            $('#clearFilters').click(function() {
                $('input[name^="department_ids[]"]').prop('checked', false);
            });
        });
    </script>
@endsection
