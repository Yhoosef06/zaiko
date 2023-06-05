@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-exclamation-triangle"></i>{{ session('status') }}
        </div>
    @endif

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
                                        <th>Room Name</th>
                                        <th>Departments</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <td>{{ $room->id }}</td>
                                            <td>{{ $room->room_name }}</td>
                                            <td>{{ $room->department->department_name }}</td>
                                            <td>
                                                {{-- <a href="{{ route('view_item_details', $item->id) }}"
                                                    class="btn btn-sm btn-primary" class="btn btn-default"
                                                    data-toggle="modal" data-target="#modal-sm"
                                                    onclick="openItemModal('{{ $item->id }}')">>
                                                    <i class="fa fa-eye"></i></a> --}}
                                                {{-- {{ $item->id }} --}}

                                                {{-- <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-item-details"
                                                    onclick="openItemModal('{{ $room->id }}')">
                                                    <i class="fa fa-eye"></i>
                                                </button> --}}

                                                <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_room', $room->id) }}">
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
                    <a href="{{ route('edit_item_details', ['id' => $room->id]) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection
