@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-exclamation-triangle"></i>{{ session('status') }}
        </div>
    @endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Inventory</h1>
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
                            <h3 class="card-title"> <strong>List of All Items</strong> </h3>
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
                                    @foreach ($items as $brand => $brandItems)
                                        @foreach ($brandItems as $model => $modelItems)
                                            @foreach ($modelItems as $description => $categoryItems)
                                                <tr>
                                                    <td>{{ $categoryItems->first()->id }}</td>
                                                    <td>{{ $categoryItems->first()->brand }}</td>
                                                    <td>{{ $categoryItems->first()->model }}</td>
                                                    <td>{{ $categoryItems->first()->category->category_name }}</td>
                                                    <td>{{ Str::limit($categoryItems->first()->description, 20, '...') }}
                                                    </td>
                                                    @php
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
                                                    @endif
                                                    <td>
                                                        @if ($categoryItems->count() == 1 && ($brandItems->count() == 1 || $modelItems->count() == 1))
                                                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                                data-target="#modal-item-details"
                                                                onclick="openItemModal('{{ $categoryItems->first()->id }}')">
                                                                <i class="fa fa-eye"></i>
                                                            </button>

                                                            <form class="form_delete_btn" method="POST"
                                                                action="{{ route('delete_item', $categoryItems->first()->id) }}">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-danger show-alert-delete-item"
                                                                    data-toggle="tooltip" title='Delete'>
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('view_item_details', ['id' => $categoryItems->first()->id]) }}"
                                                                class="btn btn-sm btn-primary"
                                                                onclick="openNewWindow(event, '{{ route('view_item_details', ['id' => $categoryItems->first()->id]) }}')">
                                                                <i class="fa fa-eye"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
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
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-item-details-label">Item Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    <a href="" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-item" tabindex="-1" role="dialog" aria-labelledby="modal-edit-item-label">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-edit-item-label">Edit Item Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form fields for editing the item details -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- <script>
    function editItemModal(itemId) {
        $(document).ready(function() {
            $('#modal-item-details').on('show.bs.modal', function() {
                $('#modal-edit-item').modal('hide');
            });
        });

        // close the current modal
        $('#modal-item-details').modal('hide');

        // open the new modal for editing the item
        $.ajax({
            url: 'edit-item-' + itemId,
            type: 'GET',
            success: function(data) {
                // Populate the modal window with the edit form
                $('#modal-edit-item .modal-body').html(data);

                // Show the modal window for editing the item
                $('#modal-edit-item').modal('show');
            },
            error: function(xhr, status, error) {
                // Display an error message if the AJAX request fails
                $('#modal-item-details .modal-body').html(
                    '<p>Failed to load edit form.</p>' +
                    '<p>Error: ' + error + '</p>'
                );
            }
        });
    }
</script> --}}

<script>
    function openItemModal(itemId) {
        $(document).ready(function() {
            $('#modal-item-details').on('show.bs.modal', function() {
                $('#modal-edit-item').modal('hide');
            });
        });
        // Send an AJAX request to fetch the item details
        $.ajax({
            url: 'get-item-' + itemId + '-details',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                const acquisitionDate = new Date(data.aquisition_date);
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const acquisitionDateStr = acquisitionDate.toLocaleDateString('en-US', options);

                // Populate the modal window with the item details
                $('#modal-item-details .modal-body').html(
                    '<p><strong>Item Number:</strong> ' + data.id + '</p>' +
                    '<p><strong>Serial Number:</strong> ' + data.serial_number + '</p>' +
                    '<p><strong>Brand:</strong> ' + data.brand + '</p>' +
                    '<p><strong>Model:</strong> ' + data.model + '</p>' +
                    '<p><strong>Category:</strong> ' + data.category.category_name + '</p>' +
                    '<p><strong>Description:</strong> ' + data.description + '</p>' +
                    '<p><strong>Quantity:</strong> ' + data.quantity + '</p>' +
                    '<p><strong>Aquisition Date:</strong> ' + acquisitionDateStr + '</p>' +
                    '<p><strong>Status:</strong> ' + data.status + '</p>' +
                    '<p><strong>Location:</strong> ' + data.room.room_name + '</p>' +
                    '<p><strong>Invnetory Tag:</strong> ' + data.inventory_tag + '</p>'
                );
                $('#modal-item-details .modal-footer').html(
                    '<button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>' +
                    '<a href="#" class="btn btn-primary" onclick="editItemModal(' + data.id +
                    ');">Edit</a>'
                );
                // Update the "Edit" button link with the correct item ID
                var editUrl = '{{ route('edit_item_details', ['id' => ':itemId']) }}';
                editUrl = editUrl.replace(':itemId', data.id);
                $('#modal-item-details .modal-footer a').attr('href', editUrl);
            },
            error: function(xhr, status, error) {
                // Display an error message if the AJAX request fails
                $('#modal-item-details .modal-body').html(
                    '<p>Failed to load item details.</p>' +
                    '<p>Error: ' + error + '</p>'
                );
            }
        });

        // Show the modal window
        $('#modal-item-details').modal('hide');
    }

    function openNewWindow(event, url) {
        event.preventDefault(); // Prevent the default link behavior
        window.open(url, '_blank'); // Open the URL in a new window or tab
    }
</script>
