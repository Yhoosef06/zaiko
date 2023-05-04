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
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Item Category</th>
                                        <th>Item Description(s)</th>
                                        <th>Serial #</th>
                                        <th>Status</th>
                                        <th>Room</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->brand }}</td>
                                            <td>{{ $item->model }}</td>
                                            <td>{{ $item->item_category }}</td>
                                            <td>{{ Str::limit($item->description, 20, '...') }}</td>
                                            <td>{{ $item->serial_number }}</td>
                                            <td>{{ $item->status }}</td>
                                            @foreach ($rooms as $room)
                                                @if ($room->id == $item->location)
                                                    <td> {{ $room->room_name }}</td>
                                                @endif
                                            @endforeach
                                            <td><a href="{{ route('view_item_details', $item->serial_number) }}"
                                                    class="btn btn-sm btn-primary" class="btn btn-default"
                                                    data-toggle="modal" data-target="#modal-sm">
                                                    <i class="fa fa-eye"></i></a>
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

    <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Item Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('update_item_details', $item->serial_number) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <strong>Room/Location:</strong>
                        <div style="display:flex">
                            <div>
                                <select id="location" name="location"
                                    class="form-control @error('location')
                                            border-danger @enderror">
                                    <option value="option_select" disabled selected>Choose a room</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <a class="btn text-blue" href="{{ route('adding_new_room') }}"><i
                                        class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>

                        @error('location')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <strong>Item Category:</strong>
                        <select id="item_category" name="item_category"
                            class="form-control col-sm-8 @error('item_category')
                            border-danger @enderror">
                            <option value="option_select" disabled selected>Select a category</option>
                            @foreach ($itemCategories as $category)
                                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('item_category')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <strong>Brand:</strong>
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                            class="form-control @error('brand')
                        border-danger
                        @enderror"
                            placeholder="Brand Name (Leave an N/A if none.)">
                        @error('brand')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <strong>Model:</strong>
                        <input type="text" id="model" name="model" value="{{ old('model') }}"
                            class="form-control @error('model')
                        border-danger
                        @enderror"
                            placeholder="Model (Leave an N/A if none.)">
                        @error('model')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <strong>Aquisition Date:</strong>
                        <input type="date" id="aquisition_date" name="aquisition_date" class="form-control"
                            placeholder="Aquistion Date">

                        <strong>Unit Number:</strong>
                        <input type="text" id="unit_number" name="unit_number"
                            class="form-control col-sm-5 @error('unit_number')
                        border-danger @enderror"
                            value="{{ old('unit_number') }}" placeholder="Unit Number     (Leave an N/A if none.)">
                        @error('unit_number')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <strong>Serial Number:</strong>
                        <input type="text" id="serial_number" name="serial_number"
                            class="form-control col-sm-6 @error('serial_number')
                    border-danger @enderror"
                            value="{{ old('serial_number') }}" placeholder="Serial Number">
                        @if (session()->has('message'))
                            <div class="text-danger">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @error('serial_number')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <strong>Description:</strong>
                        <input type="text" id="item_description" name="item_description"
                            value="{{ old('item_description') }}"
                            class="form-control @error('item_description')
                    border-danger
                    @enderror"
                            placeholder="Item Description">
                        @error('item_description')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <strong>Quantity:</strong>
                        <input type="text" id="quantity" name="quantity"
                            class="form-control col-sm-5 @error('quantity')
                    border-danger @enderror"
                            value="{{ old('quantity') }}" placeholder="Quantity">
                        @error('quantity')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <strong>Status:</strong>
                        <select id="status" name="status" class="form-control">
                            <option value="Active">Active</option>
                            <option value="For Repair">For Repair</option>
                            <option value="Obsolete">Obsolete</option>
                            <option value="Lost">Lost</option>
                        </select>

                        <strong>Inventory Tag:</strong>
                        <label for="" class="radio-inline">
                            <input type="radio" id='inventory_tag' name="inventory_tag" value="with">
                            With
                        </label>
                        /
                        <label for="" class="radio-inline">
                            <input type="radio" id='inventory_tag' name="inventory_tag" value="without" checked>
                            Without
                        </label>

                        <div class="card text-center">
                            <div class="card-header">
                                <h5>{{ $item->serial_number }} QR Code</h5>
                            </div>
                            <div class="card-body">
                                <img src="data:image/png;base64, {!! base64_encode(
                                    QrCode::format('png')->size(150)->generate($item->serial_number),
                                ) !!} " alt=""
                                    srcset=""><br>
                                <a href="data:image/png;base64, {!! base64_encode(
                                    QrCode::format('png')->size(300)->generate($item->serial_number),
                                ) !!} "
                                    download="{{ 'Item_' . $item->serial_number . '_QRCode' }}">Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
