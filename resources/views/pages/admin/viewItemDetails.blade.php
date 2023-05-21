@extends('layouts.pages.yields')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
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
                                            <button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>

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
@endsection
