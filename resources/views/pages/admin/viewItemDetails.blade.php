@extends('layouts.pages.yields')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="contaienr m-2">
                            <a href="{{ route('view_items') }}" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="card-header">
                            @foreach ($items as $item)
                                <h3 class="card-title"><strong>Brand:</strong> {{ $item->brand }} </h3> <br>
                                <h3 class="card-title"><strong>Model:</strong> {{ $item->model }} </h3> <br>
                                <h3 class="card-title"><strong>Category:</strong> {{ $item->item_category }} </h3>
                                <br>
                                <h3 class="card-title"><strong>Description:</strong> {{ $item->description }} </h3>
                            @break
                        @endforeach
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-center">
                        <table id="listofusers" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Serial #</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->serial_number }}</td>
                                        <td>{{ $item->room->room_name }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#modal-edit-item" data-item-id="{{ $item->id }}"><i
                                                    class="fa fa-edit"></i></button>

                                            <form class="form_delete_btn" method="POST"
                                                action="{{ route('delete_item', $item->id) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger show-alert-delete-item"
                                                    data-toggle="tooltip" title='Delete'>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div><!-- /.container-fluid -->
        </div>
    </div>
</section>

<div class="modal fade hide" id="modal-edit-item" tabindex="-1" role="dialog" aria-labelledby="modal-edit-item-label">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-edit-item-label">Edit Item Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-item-form">
                    <div class="form-group">
                        <label for="brand"> Brand:</label>
                        <input type="text" id="brand" name="brand" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="model"> Model:</label>
                        <input type="text" id="model" name="model" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Item name">Item Category:</label>
                        <select id="item_category" name="item_category"
                            class="form-control col-5 @error('item_category')
                    border-danger @enderror">
                            @foreach ($itemCategories as $category)
                                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Item Description">Item Description:</label>
                        <input type="text" id="description" name="description" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="aquisition date">Aquisition Date:</label>
                        <input type="date" id="aquisition_date" name="aquisition_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="serial number"> Serial Number:</label>
                        <input type="text" id="serial_number" name="serial_number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="location">Room/Location:</label>
                        <select id="location" name="location" class="form-control">
                            @foreach ($rooms as $room)
                                @if ($room->id == $item->location)
                                    <option value="{{ $room->id }}" selected>{{ $room->room_name }}</option>
                                @endif
                            @endforeach

                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" name="status" class="form-control">
                            <option value="{{ $item->status }}">{{ $item->status }}</option>
                            <option value="Active">Active</option>
                            <option value="For Repair">For Repair</option>
                            <option value="Obsolete">Obsolete</option>
                            <option value="Obsolete">Lost</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="borrowed or not">Inventory Tag:</label>
                        @if ($item->inventory_tag == 'with')
                            <label for="" class="radio-inline">
                                <input type="radio" id='inventory_tag' name="inventory_tag" value="with"
                                    checked>
                                With
                            </label>
                            /
                            <label for="" class="radio-inline">
                                <input type="radio" id='inventory_tag' name="inventory_tag" value="without">
                                Without
                            </label>
                        @else
                            <label for="" class="radio-inline">
                                <input type="radio" id='inventory_tag' name="inventory_tag" value="with">
                                With
                            </label>
                            /
                            <label for="" class="radio-inline">
                                <input type="radio" id='inventory_tag' name="inventory_tag" value="without"
                                    checked>
                                Without
                            </label>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save-changes-btn" id="saveChangesBtn"
                    data-item-id="{{ $item->id }}">Save Changes</button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#modal-edit-item').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            var itemId = button.data('item-id'); 
            openItemModal(itemId);
        });

        $('#modal-edit-item').on('click', '.save-changes-btn', function() {
            var itemId = $(this).data('item-id');
            saveChanges(itemId);
        });
    });

    function openItemModal(itemId) {
        $.ajax({
            url: 'get-item-' + itemId + '-details',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#serial_number').val(data.serial_number);
                $('#location').val(data.location);
                $('#status').val(data.status);
                $('#brand').val(data.brand);
                $('#model').val(data.model);
                $('#description').val(data.description);
                $('#aquisition_date').val(data.aquisition_date);
                $('#item_category').val(data.item_category);

                $('#saveChangesBtn').data('item-id', itemId);

                $('#modal-edit-item').modal('hide');
            },
            error: function(xhr, status, error) {

                console.log(error);
            }
        });
    }

    function saveChanges(itemId) {
        var serial_number = $('#serial_number').val();
        var location = $('#location').val();
        var status = $('#status').val();
        var brand = $('#brand').val();
        var model = $('#model').val();
        var inventory_tag = $('#inventory_tag').val();
        var description = $('#description').val();
        var aquisition_date = $('#aquisition_date').val();
        var item_category = $('#item_category').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (confirm("Are you sure you want to save the changes?")) {
            $.ajax({
                url: 'updating-item-' + itemId + '-details',
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    serial_number: serial_number,
                    location: location,
                    status: status,
                    brand: brand,
                    model: model,
                    inventory_tag: inventory_tag,
                    description: description,
                    aquisition_date: aquisition_date,
                    item_category: item_category,
                },
                success: function(response) {
                    console.log(response);

                    if (response.success) {

                        alert(response.message);

                         window.location.reload();
                    } else {
        
                        alert('Failed to save changes: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    }
</script>
