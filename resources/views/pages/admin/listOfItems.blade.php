@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">List of All Items</h1>
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
                                <div class="ml-1 float-md-right">
                                    <button name="searchFilter" class="btn bg-yellow" data-toggle="modal"
                                        data-target="#filterModal" data-toggle="tooltip" title="Filter Items"><i
                                            class="fa fa-filter" onclick="filterItems()"></i></button>
                                </div>

                                <div class="ml-1 float-md-right">
                                    <a href="{{ route('sort_items', ['order' => 'asc']) }}"
                                        class="btn bg-yellow {{ $sortOrder === 'asc' ? 'active' : '' }}"
                                        data-toggle="tooltip" title="Sort By Row # (Ascending)">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>

                                <div class="ml-1 float-md-right">
                                    <a href="{{ route('sort_items', ['order' => 'desc']) }}"
                                        class="btn bg-yellow {{ $sortOrder === 'desc' ? 'active' : '' }}"
                                        data-toggle="tooltip" title="Sort By Row # (Descending)">
                                        <i class="fa fa-chevron-down"></i>
                                    </a>
                                </div>

                                <div class="search-bar mb-2 float-md-right">
                                    <form action="{{ route('items.search') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search items..."
                                                value="{{ old('search', request('search')) }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn bg-yellow" data-toggle="tooltip"
                                                    title="Search">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <table id="listofitems" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Location</th>
                                            <th>Quantity</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($items as $item)
                                            <tr data-item-id="{{ $item->id }}">
                                                <td>{{ $item->id }}</td>
                                                <td>
                                                    {{ $item->brand_id ? $item->brand->brand_name : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $item->model_id ? $item->model->model_name : 'N/A' }}
                                                </td>
                                                <td>{{ $item->category->category_name }}</td>
                                                <td>{{ Str::limit($item->description, 30, '...') }} </td>
                                                <td>{{ $item->room->room_name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#modal-item-details" data-toggle="tooltip"
                                                        title='View' onclick="openItemModal('{{ $item->id }}')">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#addSubItemModal" data-toggle="tooltip"
                                                        title='Add Sub Item'
                                                        data-route="{{ route('add_sub_item', ['id' => $item->id]) }}"
                                                        onclick="openAddSubItemModal({{ $item->id }}, $(this).data('route'))">
                                                        <i class="fa fa-plus-square"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#modal-transfer-item" data-toggle="tooltip"
                                                        title='Transfer Item'
                                                        data-route="{{ route('transfer_item', ['id' => $item->id]) }}"
                                                        onclick="openTransferItemModal({{ $item->id }}, $(this).data('route'))">
                                                        <i class="fa fa-arrow-alt-circle-right"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#modal-replace-item" data-toggle="tooltip"
                                                        title='Replace Item'
                                                        data-route="{{ route('replace_item', ['id' => $item->id]) }}"
                                                        onclick="openReplaceItemModal({{ $item->id }}, $(this).data('route'))">
                                                        <i class="fa fa-exchange-alt"></i>
                                                    </button>

                                                    @if ($item->borrowed == 'no')
                                                        <form class="form_delete_btn" method="POST"
                                                            action="{{ route('delete_item', $item->id) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger show-alert-delete-item"
                                                                data-toggle="modal" data-target="#show-alert-delete-item"
                                                                data-toggle="tooltip" title='Delete'
                                                                onclick="deleteButton({{ $item->id }})">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center bg-white">No available data in the
                                                    table</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-md-right">
                                {{ $items->links() }}
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
    <div class="modal fade" id="modal-item-details" tabindex="-1" role="dialog"
        aria-labelledby="modal-item-details-label">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-item-details-label">Item Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-replace-item" tabindex="-1" role="dialog" aria-labelledby="modal-replace-item">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-replace-item">Replace Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form fields for editing the item details -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-transfer-item" tabindex="-1" role="dialog"
        aria-labelledby="modal-edit-item-label">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-transfer-item-label">Transfer Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form fields for editing the item details -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSubItemModal" tabindex="-1" role="dialog" aria-labelledby="addSubItemModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addSubItemModalLabel">Adding Sub Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form fields for editing the item details -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Filtering -->
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
                <form id="filterForm" method="GET" action="{{ route('get_filtered_items') }}">
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="brandFilter">Brand:</label>
                                <div>
                                    @foreach ($filterItems->unique('brand.brand_name') as $item)
                                        <input type="checkbox" name="brand_ids[]" value="{{ $item->brand_id }}"
                                            @if (in_array($item->brand_id, request('brand_ids', []))) checked @endif>
                                        {{ $item->brand->brand_name }}<br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="locationFilter">Model:</label>
                                <div>
                                    @foreach ($filterItems->unique('model.model_name') as $item)
                                        <input type="checkbox" name="model_ids[]" value="{{ $item->model_id }}"
                                            @if (in_array($item->model_id, request('model_ids', []))) checked @endif>
                                        {{ $item->model->model_name }}<br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="categoryFilter">Category:</label>
                                <div>
                                    @foreach ($filterItems->unique('category.category_name') as $item)
                                        <input type="checkbox" name="category_ids[]" value="{{ $item->category_id }}"
                                            @if (in_array($item->category_id, request('category_ids', []))) checked @endif>
                                        {{ $item->category->category_name }}<br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="locationFilter">Location:</label>
                                <div>
                                    @foreach ($filterItems->unique('room.room_name') as $item)
                                        <input type="checkbox" name="room_ids[]" value="{{ $item->location }}"
                                            @if (in_array($item->location, request('room_ids', []))) checked @endif>
                                        {{ $item->room->room_name }}<br>
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
        function deleteButton(itemId) {
            // Remove previous highlighting
            $('#listofitems tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofitems tbody tr[data-item-id="' + itemId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });
        }

        function openItemModal(itemId) {
            var modal = $('#modal-item-details');
            var url = "{{ route('view_item_details', ['id' => ':itemId']) }}".replace(':itemId', itemId);
            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Remove previous highlighting
            $('#listofitems tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofitems tbody tr[data-item-id="' + itemId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });


            $.get(url, function(data) {
                modal.find('.modal-body').html(data);
            });
        }

        function openNewWindow(event, url) {
            event.preventDefault(); // Prevent the default link behavior
            window.open(url, '_blank'); // Open the URL in a new window or tab
        }

        function openTransferItemModal(itemId, route) {
            // Remove previous highlighting
            $('#listofitems tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofitems tbody tr[data-item-id="' + itemId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

            var modal = $('#modal-transfer-item');

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Send an AJAX request to fetch the edit view content
            // for the specific college
            $.get(route, {
                item_id: itemId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }

        function openAddSubItemModal(itemId, route) {
            // Remove previous highlighting
            $('#listofitems tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofitems tbody tr[data-item-id="' + itemId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

            var modal = $('#addSubItemModal');

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Send an AJAX request to fetch the edit view content
            // for the specific college
            $.get(route, {
                item_id: itemId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }

        function openReplaceItemModal(itemId, route) {
            // Remove previous highlighting
            $('#listofitems tbody tr').css({
                'box-shadow': 'none',
                'background-color': 'transparent'
            });

            // Add the highlighted class to the clicked row
            $('#listofitems tbody tr[data-item-id="' + itemId + '"]').css({
                'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)', // Adjust the shadow parameters as needed
                'background-color': '#A9F5F2' // Adjust the color as needed
            });

            var modal = $('#modal-replace-item');

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            // Send an AJAX request to fetch the edit view content
            // for the specific college
            $.get(route, {
                item_id: itemId
            }, function(data) {
                modal.find('.modal-body').html(data);
            });
        }

        $(document).ready(function() {
            // Listen for the "Clear" button click
            $('#clearFilters').click(function() {
                // Uncheck all checkboxes with the specified names
                $('input[name^="brand_ids"], input[name^="model_ids"], input[name^="category_ids"], input[name^="room_ids"]')
                    .prop('checked', false);
            });
        });
    </script>
    <style>
        /* for sort buttons */
        .active {
            background-color: #007bff;
            color: #fff;
        }
    </style>
@endsection
