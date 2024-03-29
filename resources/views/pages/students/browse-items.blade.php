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
        <div class="input-group input-group-lg pb-5">
            <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here" value="Lorem ipsum">
            <div class="input-group-append">
                <button type="submit" class="btn btn-lg btn-default">
                <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <section class="content">
            <div class="row">
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
                    <div class="col-lg-3 col-md-5 mb-4">
                        <div class="card">
                            <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light text-center"
                                data-mdb-ripple-color="light">
                                @if ($item->item_image == null)
                                    <div class="container border border-2"
                                        style="width: 250px; height: 250px; display: flex; justify-content: center; align-items: center;">
                                        <p style="text-align: center;">No image found.</p>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $item->item_image) }}" width="250px"
                                        height="250px">
                                @endif
                                <div class="mask">
                                    <div class="d-flex justify-content-start align-items-end h-100">
                                        <h5>
                                            <span class="badge bg-success ms-2">
                                                {{Str::limit($item->room->department->department_name,25)}}
                                            </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <div class="row mx-auto">
                                    <span
                                        class="card-title mb-3 font-weight-bold display-3">{{ $item->brand->brand_name }}</span>
                                    <h5 class="card-title mb-3">{{ $item->model->model_name }}</h5>
                                    <p></p>
                                </div>
                                <button type="button" class="btn btn-link text-success" data-toggle="modal"
                                    data-target="#itemModal{{ $item->id }}">
                                    More info <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="itemModal{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="itemModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="itemModalLabel">Item Information</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row text-lg">
                                        <div class="col">
                                            @if ($item->item_image == null)
                                                <div
                                                    style="border: 1px solid #000; width: 200px; height: 200px; display: flex; justify-content: center; align-items: center;">
                                                    <p>No image found.</p>
                                                </div>
                                            @else
                                                <img src="{{ asset('storage/' . $item->item_image) }}"
                                                    alt="" srcset="" width="200px" height="200px">
                                            @endif
                                            <strong>Brand:</strong> {{ $item->brand->brand_name }}
                                            <br>
                                            <strong>Model:</strong> {{ $item->model->model_name }}
                                            <br>
                                            @php
                                                $missingQty = 0;
                                                $borrowedQty = 0;
                                                $totalDeduct = 0;
                                                foreach ($borrowedList as $borrowed) {
                                                    if ($borrowed->item_id == $item->id) {
                                                        $borrowedQty = $borrowedQty + $borrowed->order_quantity;
                                                    }
                                                }

                                                foreach ($missingList as $missing) {
                                                    if ($missing->item_id == $item->id) {
                                                        $missingQty = $missingQty + $missing->quantity;
                                                    }
                                                }
                                                $totalDeduct = $missingQty + $borrowedQty;

                                            @endphp
                                            <strong>Available:</strong>
                                            {{ $totalquantity - $totalDeduct }} <br>
                                        </div>
                                        <div class="col">
                                            <strong>Description:</strong> {{ $item->description }}
                                            <br>
                                            <strong>Status:</strong> {{ $item->status }}
                                        </div>
                                    </div>
                                    <form action="{{ route('add.cart', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to add this item to your cart?');">
                                        @csrf
                                        <label for="quantity">Quantity:</label>
                                        <div class="form-group col-2">

                                            <select class="form-control" id="quantity" name="quantity">
                                                @php
                                                    $missingQty = 0;
                                                    $borrowedQty = 0;
                                                    $totalDeduct = 0;
                                                    foreach ($borrowedList as $borrowed) {
                                                        if ($borrowed->item_id == $item->id) {
                                                            $borrowedQty = $borrowedQty + $borrowed->order_quantity;
                                                        }
                                                    }

                                                    foreach ($missingList as $missing) {
                                                        if ($missing->item_id == $item->id) {
                                                            $missingQty = $missingQty + $missing->quantity;
                                                        }
                                                    }
                                                    $totalDeduct = $missingQty + $borrowedQty;

                                                @endphp
                                                @for ($i = 1; $i <= $totalquantity - $totalDeduct; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>

                                        </div>
                                        <div class="modal-footer">
                                            <i class="fas fa-cart-plus"></i><input type="submit"
                                                class="btn btn-success" value="Add to cart">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                                    <!-- Add your item information here -->
                                    <!-- You can display item details or any other content here -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>

@endsection
