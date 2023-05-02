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
                                            <td> {{ $item->location }}</td>
                                            <td><a href="{{ route('view_item_details', $item->serial_number) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye"></i></a>
                                                <a href="{{ route('edit_item_details', $item->serial_number) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i></a>
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
@endsection
