@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">{{ Auth::user()->account_type == 'faculty' ? 'Students' : 'Users' }}</h1> --}}
                    <h1 class="text-decoration-underline">List of All Users</h1>
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
                                    <form action="{{ route('users.search') }}" method="GET">
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
                                <table id="listofusers" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID #</th>
                                            <th>Name</th>
                                            @if (Auth::user()->roles->contains('name', 'admin'))
                                                <th>Role</th>
                                            @endif
                                            <th>Status</th>
                                            @if (Auth::user()->roles->contains('name', 'admin'))
                                                <th>Type</th>
                                            @endif
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            @if ($user->id_number != Auth::user()->id_number)
                                                <tr data-user-id="{{ $user->id_number }}">
                                                    <td>{{ $user->id_number }}</td>
                                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                    @if (Auth::user()->roles->contains('name', 'admin'))
                                                        <td>
                                                            @foreach ($user->roles as $role)
                                                                {{ $role->name }} <br>
                                                            @endforeach
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if ($user->isActive)
                                                            <p class="bg-green text-center">Active</p>
                                                        @else
                                                            <p class="bg-gray text-center">Inactive</p>
                                                        @endif
                                                    </td>
                                                    @if (Auth::user()->roles->contains('name', 'admin'))
                                                        <td>
                                                            {{ $user->account_type }}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                            data-target="#modal-user-info" data-toggle="tooltip"
                                                            title='View'
                                                            onclick="openViewUserModal('{{ $user->id_number }}')">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        @if (Auth::user()->roles->contains('name', 'admin'))
                                                            <form class="form_delete_btn" method="POST"
                                                                action="{{ route('delete_user', $user->id_number) }}">
                                                                @csrf
                                                                <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-danger show-alert-delete-item"
                                                                    data-toggle="tooltip" title='Delete'
                                                                    onclick="deleteButton({{ $user->id_number }})"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center bg-white">No available data.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-md-right">
                                {{ $users->links() }}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-user-info" tabindex="-1" role="dialog" aria-labelledby="modal-user-info">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-user-info">
                        User Information
                    </h4>
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
                    <h5 class="modal-title" id="filterModalLabel">Filter Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" method="GET" action="{{ route('get_filtered_users') }}">
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="brandFilter">Role:</label>
                                <div>
                                    @foreach ($uniqueRoles as $role)
                                        <input type="checkbox" name="role_ids[]" value="{{ $role->id }}"
                                            @if (in_array($role->id, request('role_ids', []))) checked @endif>
                                        {{ $role->name }}<br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="locationFilter">Status:</label>
                                <div>
                                    <div>
                                        <input type="checkbox" name="status[]" value="1" {{ in_array('1', (array)request('status')) ? 'checked' : '' }}>
                                        Active<br>
                                    
                                        <input type="checkbox" name="status[]" value="0" {{ in_array('0', (array)request('status')) ? 'checked' : '' }}>
                                        Inactive<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="categoryFilter">Type:</label>
                                <div>
                                    @foreach ($filterUsers->unique('account_type') as $user)
                                        <input type="checkbox" name="account_type" value="{{ $user->account_type }}"
                                            @if ($user->account_type == request('account_type')) checked @endif>
                                        {{ $user->account_type }}<br>
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
        function deleteButton(userId) {
            // Remove previous highlighting
            $('#listofusers tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofusers tbody tr[data-user-id="' + userId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        function openViewUserModal(userId) {
            var modal = $('#modal-user-info');
            var url = "{{ route('view_user_info', ['id_number' => ':userId']) }}".replace(':userId', userId);
            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Remove previous highlighting
            $('#listofusers tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofusers tbody tr[data-user-id="' + userId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });


            $.get(url, function(data) {
                modal.find('.modal-body').html(data);
            });
        }


        $(document).ready(function() {
            // Listen for the "Clear" button click
            $('#clearFilters').click(function() {

                // Uncheck all checkboxes with names starting with "brand_ids[]"
                $('input[name^="role_ids[]"]').prop('checked', false);

                // Uncheck all checkboxes with names starting with "model_ids[]"
                $('input[name^="status"]').prop('checked', false);

                // Uncheck all checkboxes with names starting with "category_ids[]"
                $('input[name^="account_type"]').prop('checked', false);
            });
        });
    </script>
@endsection
