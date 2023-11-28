@extends('layouts.pages.yields')


@section('content')
    <div class="borrower-bg borrower-page-height container-fluid pl-5 pr-5">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Browse Items</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            @foreach ($groupedItems as $groupedItem)
                @php
                $totalquantity = 0;
                if (count($groupedItem) != 0) {
                    foreach ($groupedItem as $item) {
                        $totalquantity += $item->quantity;
                    }
                    $item = $groupedItem->first();
                }
                @endphp
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th> ---- </th>
                                <th>Quantity</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                {{-- @dd($item); --}}
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->brand->brand_name }}</td>
                                <td>{{ $item->model->model_name }}</td>
                                <td> -- </td>
                                <td>{{ $totalquantity }}</td>
                                <!-- Add more columns as needed -->
                            </tr>
                        </tbody>
                    </table>
            @endforeach
        </section>

    </div>

@endsection
