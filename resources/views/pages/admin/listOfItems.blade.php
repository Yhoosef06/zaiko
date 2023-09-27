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
                                    @foreach ($items as $item)
                                        <tr data-item-id="{{ $item->id }}">
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                {{ $item->brand_id ? $item->brand->brand_name : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $item->model_id ? $item->model->model_name : 'N/A' }}
                                            </td>
                                            <td>{{ $item->category->category_name }}</td>
                                            <td>{{ Str::limit($item->description, 20, '...') }}</td>
                                            <td>{{ $item->room->room_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-item-details" data-toggle="tooltip" title='View'
                                                    onclick="openItemModal('{{ $item->id }}')">
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
    </script>
@endsection
