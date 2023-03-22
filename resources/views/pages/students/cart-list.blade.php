@extends('layouts.students.yields')


@section('content')
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Items in Cart</h1>
                        </div>
                    </div>
                </div>
            </div>
            <table id="cart" class="table">

                <thead>
                    <tr>
                        <th style="width:10%" class="text-wrap">Serial Number</th>
                        <th style="width:10%" class="text-wrap">Unit Number</th>
                        <th style="width:20%" class="text-wrap">Item Name</th>
                        <th style="width:45%" class="text-wrap">Item Description</th>
                        <th style="width:25%" class="text-wrap text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(session('cart'))
                        @foreach(session('cart') as $serial_number => $item)
                        <tr data-id="{{ $serial_number}}">
                            <td class="text-wrap">{{ $serial_number }}</td>
                            <td class="text-wrap">{{ $item['unit_number'] }}</td>
                            <td class="text-wrap">{{ $item['item_name'] }}</td>
                            <td class="text-wrap">{{ $item['item_description'] }}</td>
                            <td class="text-center actions" data-id="">
                                {{-- <button class="btn btn-danger btn-sm" id="cart_remove"><i class="bi bi-x-circle"></i> Remove</button> --}}
                                <form action="{{ route('remove_item', $serial_number) }}" method="POST"
                                    class="form-check-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit"
                                        class="border-0 text-danger text-decoration-underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" class="text-right">
                            <a href="{{ route('student.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                            <button class="btn btn-success"><i class="bi bi-check2"></i> Borrow Items</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        $('#cart_remove').on(click(function (e){
            e.preventDefault();

            var ele = $(this);

            if(confirm("Do you really want to remove?")){
                $.ajax({
                    url: '{{ route('remove.from.cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function(response){
                        window.location.reload();
                    }
                })
            }
        }));
    </script>

@endsection