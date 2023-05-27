@extends('layouts.pages.yields')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-decoration-underline">Browse Items</h3>
                </div>
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Items available to borrow</li>
                    </ol>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


                    <div class="card">
                        {{-- <div class="card-header">
                            <h3 class="card-title"> <strong>List of All Items</strong> </h3>
                        </div> --}}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="listofitems" class="table table-bordered table-striped">
                                <thead>
                                    <tr class=" text-center">
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Available</th>
                                        <th>QTY</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                <div class="container">
                                                    <strong>Brand:</strong> {{ $item->brand }} <br>
                                                    <strong>Model:</strong> {{ $item->model }} <br>
                                                    <strong>Category:</strong> {{ $item->item_category }} <br>
                                                    <strong>Description:</strong>
                                                    {{ Str::limit($item->description, 20, '...') }} <br>
                                                    <strong>Serial Number:</strong> {{ $item->serial_number }} <br>
                                                    <strong>Location:</strong> {{ $item->room->room_name }} <br>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->quantity }}
                                            </td>
                                            <td>
                                                <button class="btn btn-default btn-sm minus-btn">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input id="quantity-input" type="number" value="0" min="0"
                                                    max="{{ $item->quantity }}">
                                                <button class="btn btn-default btn-sm plus-btn">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                                            <td>
                                                {{-- <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-item-details"
                                                    onclick="openItemModal('{{ $item->id }}')">
                                                    <i class="fa fa-eye"></i>
                                                </button> --}}

                                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-item-details"
                                                    onclick="openItemModal('{{ $item->id }}')">
                                                    Add to cart
                                                </button>

                                                {{-- <form class="form_delete_btn" method="POST"
                                                    action="{{ route('delete_item', $item->id) }}">
                                                    @csrf
                                                    <!-- <input name="_method" type="hidden" value="DELETE">  -->
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger show-alert-delete-item"
                                                        data-toggle="tooltip" title='Delete'><i
                                                            class="fa fa-trash"></i></button>
                                                </form> --}}
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.plus-btn').click(function(e) {
            e.preventDefault();
            var input = $('#quantity-input');
            var currentValue = parseInt(input.val());
            var maxValue = parseInt(input.attr('max'));

            if (currentValue < maxValue) {
                input.val(currentValue + 1);
            }
        });

        $('.minus-btn').click(function(e) {
            e.preventDefault();
            var input = $('#quantity-input');
            var currentValue = parseInt(input.val());
            var minValue = parseInt(input.attr('min'));

            if (currentValue > minValue) {
                input.val(currentValue - 1);
            }
        });
    });
</script>
