@extends('layouts.pages.yields')

@section('content')
    {{-- @if (session('status'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-exclamation-triangle"></i>{{ session('status') }}
        </div>
    @endif --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">Inventory</h1> --}}
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
                            <h3>List of All Items</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="listofitems" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($items as $brand => $brandItems)
                                        @foreach ($brandItems as $model => $modelItems)
                                            @foreach ($modelItems as $description => $categoryItems) --}}
                                    @foreach ($items as $item)
                                        <tr data-item-id="{{ $item->id }}">
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if ($item->brand_id == null)
                                                    N/A
                                                @else
                                                    {{ $item->brand->brand_name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->model_id == null)
                                                    N/A
                                                @else
                                                    {{ $item->model->model_name }}
                                                @endif
                                            </td>
                                            <td>{{ $item->category->category_name }}</td>
                                            <td>{{ Str::limit($item->description, 20, '...') }}
                                            <td>{{ $item->quantity }}</td>
                                            </td>
                                            {{-- @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($categoryItems as $item)
                                                @php
                                                    $total += $item->quantity;
                                                @endphp
                                            @endforeach
                                            @if ($categoryItems->count() == 1 && ($brandItems->count() == 1 || $modelItems->count() == 1))
                                                <td>{{ $categoryItems->first()->quantity }}</td>
                                            @else
                                                <td>{{ $total }}</td>
                                            @endif --}}
                                            <td>
                                                {{-- @if ($categoryItems->count() == 1 && ($brandItems->count() == 1 || $modelItems->count() == 1)) --}}
                                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-item-details" data-toggle="tooltip" title='View'
                                                    onclick="openItemModal('{{ $item->id }}')">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                {{-- <a href="{{ route('view_item_details', ['id' => $item->id]) }}">View</a> --}}

                                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-add-sub-item" data-toggle="tooltip"
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

                                                <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_item', $item->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger show-alert-delete-item"
                                                        data-toggle="tooltip" title='Delete'
                                                        onclick="deleteButton({{ $item->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                {{-- @else
                                                                <a href="{{ route('view_item_details', ['id' => $categoryItems->first()->id]) }}"
                                                                    class="btn btn-sm btn-primary"
                                                                    onclick="openNewWindow(event, '{{ route('view_item_details', ['id' => $categoryItems->first()->id]) }}')">
                                                                    <i class="fa fa-eye"></i>
                                                            @endif --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- @endforeach
                                        @endforeach
                                    @endforeach --}}
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
        <div class="modal-dialog modal-m" role="document">
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

    <div class="modal fade" id="modal-add-sub-item" tabindex="-1" role="dialog" aria-labelledby="modal-add-sub-item">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-add-sub-item">Adding Sub Item</h4>
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
@endsection

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

        var modal = $('#modal-add-sub-item');

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
