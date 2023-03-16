@extends('pages.admin.home')

@section('content')
<h4>List of All Items</h4>
    <div class="content shadow-sm p-2">
        @if ($items->count())
            <table class="table">
                @if (session('status'))
                    <div class="container alert text-center">
                        <h4>{{ session('status') }}</h4>
                    </div>
                @endif
                <form action="{{ route('filtered_view') }}" type="get" method="get" role="search">
                    @csrf
                    <div class="input-group mb-3 d-flex flex-row-reverse">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                        <input type="text" class="form-control col-2" name="query" id="query" placeholder="">
                    </div>
                </form>
                <thead>
                    <tr>
                        <th scope="col">Serial #</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Item Description</th>
                        <th scope="col">Qty.</th>
                        <th scope="col">Location</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <th>{{ $item->serial_number }}</th>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ Str::limit($item->item_description, 20, '...') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->location }}</td>
                            <td><a href="{{ route('view_item_details', $item->serial_number) }}"
                                    class="text-success">View</a>/
                                <a href="{{ route('edit_item_details', $item->serial_number) }}">Edit</a>/
                                <form action="{{ route('delete_item', $item->serial_number) }}" method="POST"
                                    class="form-check-inline">
                                    @csrf
                                    <button type="submit"
                                        class="border-0 text-danger text-decoration-underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                <h5>{{ $items->links() }}</h5>
            </div>
        @else
            <div class="text-center">
                <form action="{{ route('filtered_view') }}" type="get" method="get" role="search">
                    @csrf
                    <div class="input-group mb-3 d-flex flex-row-reverse">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                        <input type="text" class="form-control col-2" name="query" id="query" placeholder="">
                    </div>
                </form>
                Data not found.
            </div>
        @endif
    </div>
@endsection
