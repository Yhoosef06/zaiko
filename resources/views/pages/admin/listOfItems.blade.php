@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventory</h1>
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
                                        <th>Serial #</th>
                                        <th>Status</th>
                                        <th>Room</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->brand }}</td>
                                            <td>{{ $item->model }}</td>
                                            <td>{{ $item->item_category }}</td>
                                            <td>{{ Str::limit($item->description, 20, '...') }}</td>
                                            <td>{{ $item->serial_number }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->room->room_name }}</td>
                                            <td>
                                                {{-- <a href="{{ route('view_item_details', $item->id) }}"
                                                    class="btn btn-sm btn-primary" class="btn btn-default"
                                                    data-toggle="modal" data-target="#modal-sm"
                                                    onclick="openItemModal('{{ $item->id }}')">>
                                                    <i class="fa fa-eye"></i></a> --}}
                                                {{-- {{ $item->id }} --}}

                                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-item-details"
                                                    onclick="openItemModal('{{ $item->id }}')">
                                                    <i class="fa fa-eye"></i>
                                                </button>


                                                {{-- <a href="{{ route('edit_item_details', $item->serial_number) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i></a> --}}
                                                <!-- <a href="" data-id="{{ $item->serial_number }}" class="btn btn-sm btn-danger show-alert-delete-item">
                                                                                                                                              <i class="fa fa-trash"></i></a> -->

                                                <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_item', $item->id) }}">
                                                    @csrf
                                                    <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger show-alert-delete-item"
                                                        data-toggle="tooltip" title='Delete'><i
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
                    <a href="{{ route('edit_item_details', ['id' => $item->id]) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function openItemModal(itemId) {
        // Send an AJAX request to fetch the item details
        $.ajax({
            url: 'get-item-' + itemId + '-details',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                // Populate the modal window with the item details
                $('#modal-item-details .modal-body').html(
                    '<p><strong>Item Number:</strong> ' + data.id + '</p>' +
                    '<p><strong>Serial Number:</strong> ' + data.serial_number + '</p>' +
                    '<p><strong>Unit Number:</strong> ' + data.unit_number + '</p>' +
                    '<p><strong>Brand:</strong> ' + data.brand + '</p>' +
                    '<p><strong>Model:</strong> ' + data.model + '</p>' +
                    '<p><strong>Category:</strong> ' + data.item_category + '</p>' +
                    '<p><strong>Description:</strong> ' + data.description + '</p>' +
                    '<p><strong>Quantity:</strong> ' + data.quantity + '</p>' +
                    '<p><strong>Aquisition Date:</strong> ' + data.aquisition_date + '</p>' +
                    '<p><strong>Status:</strong> ' + data.status + '</p>' +
                    '<p><strong>Location:</strong> ' + data.room.room_name + '</p>' +
                    '<p><strong>Invnetory Tag:</strong> ' + data.inventory_tag + '</p>' 
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
</script>
