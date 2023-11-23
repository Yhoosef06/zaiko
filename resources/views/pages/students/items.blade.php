@extends('layouts.pages.yields')


@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('plugins/preloader.css') }}"> --}}
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

        {{-- <div id="preloader" class="d-flex align-items-center justify-content-center">
            <div id="preloader" class="d-flex align-items-center justify-content-center">
                <div class="spinner-grow text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
    
        </div>
     

        <script>
            $(window).on('load', function() {
                // Remove the preloader and show the content section when the page is fully loaded
                $('#preloader').fadeOut('slow', function() {
                    $(this).remove(); // Remove the preloader element from the DOM
                    $('.content').fadeIn('slow');
                });
            });
        </script> --}}


        <section class="content">
            <div class="">
                <div class="row">
                    <div class="col-3">
                        <form action=" {{ route('browse.department') }}" method="GET">
                            @csrf
                            <select class="form-select form-select-lg mb-5" aria-label="Default select example"
                                name="selectedDepartment" onchange="this.form.submit()">
                                <option selected value="" disabled>Choose Department</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ Session::get('department') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        @isset($categories)
                            <form action="{{ route('browse.category') }}" method="GET">
                                @csrf
                                @foreach ($categories as $cat)
                                    <div class="form-check pb-3">
                                        <input type="radio" class="form-check-input" name="category" id="category"
                                            value="{{ $cat->id }}"
                                            {{ Session::get('category') == $cat->id ? 'checked' : '' }}
                                            onclick="this.form.submit()">
                                        <label for="category" class="form-check-label">
                                            {{ $cat->category_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </form>
                        @endisset
                    </div>
                    <div class="col-10">
                        @isset($items)
                            @php
                                $groupedItems = $items->groupBy(function ($item) {
                                    return $item->brand_id . '-' . $item->model_id;
                                });
                            @endphp
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
                                                    <img src="https://cdn.stocksnap.io/img-thumbs/960w/office-work_KJKDM1OT2J.jpg"
                                                        class="w-100" />
                                                @else
                                                    <img src="{{ asset('storage/' . $item->item_image) }}" width="250px" height="250px">
                                                @endif
                                                <div class="mask">
                                                    <div class="d-flex justify-content-start align-items-end h-100">
                                                        <h5>
                                                            <span class="badge bg-success ms-2">
                                                                Available
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
                                                                    No Image
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
                        @endisset
                    </div>
                </div>


            </div>
        </section>

    </div>

@endsection
