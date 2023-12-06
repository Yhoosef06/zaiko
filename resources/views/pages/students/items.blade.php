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
            <div class="">
                <div class="row mb-5">
                    <div class="col-3">         
                        <form action=" {{ route('browse.department') }}" method="GET">
                            @csrf          
                            <select class="form-select" aria-label="Default select example" name="selectedDepartment" onchange="this.form.submit()">
                                <option selected value="" disabled>Choose Department</option>
                                <option value="0"
                                {{ (!Session::has('department')) ? 'selected' : '' }}>
                                    All Departments
                                </option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ Session::get('department') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    @isset($categories)
                        <div class="col-3">         
                            <form action="{{ route('browse.category') }}" method="GET">
                                @csrf         
                                <select class="form-select" aria-label="Default select example" name="category" onchange="this.form.submit()">
                                    <option selected value="" disabled>Choose category</option>
                                    <option value="0"
                                    {{ (!Session::has('category')) ? 'selected' : '' }}>
                                        All Categories
                                    </option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ Session::get('category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    @endisset
                    <div class="col-6">
                        <form action=" {{ route('browse.search') }}" method="GET" id="searchForm">
                            @csrf
                                <div class="input-group mx-auto">
                                    <input type="search" class="form-control col-md-6" placeholder="Enter keyword here" name="search" id="search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        @if (isset($items) || isset($searchedItems))
                            @php
                            if(isset($items)){
                                if(count($items) != 0){
                                    $groupedItems = $items->groupBy(function ($item) {
                                        return $item->brand_id . '-' . $item->model_id;
                                    });
                                }
                            }
                            if(isset($searchedItems)){
                                if(count($searchedItems) != 0){
                                    $groupedItems = $searchedItems->groupBy(function ($item) {
                                        return $item->brand_id . '-' . $item->model_id;
                                });
                                }
                            }
                            
                            @endphp
                            @if(!isset($groupedItems))
                                <div class="row">
                                    <div class="container-fluid mt-3 mb-3">
                                        <label>No results found.</label><br>
                                    </div>
                                </div>
                            @elseif(isset($searchedItems))
                                @if(count($searchedItems) == 0)
                                    <div class="row">
                                        <div class="container-fluid mt-3 mb-3">
                                            <label>No results based on search</label><br>
                                            <label>Displaying other items</label>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            
                            <div class="row">
                                @if(isset($groupedItems))
                                    @foreach ($groupedItems as $groupedItem)
                                        @php
                                            $totalquantity = 0;
                                            if (count($groupedItem) != 0) {
                                                foreach ($groupedItem as $item) {
                                                    $totalquantity += $item->quantity;
                                                }
                                                $item = $groupedItem->first();
                                            }
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
                                        <div class="col-lg-2 col-md-3 mb-3">
                                            <div class="card">
                                                <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light text-center"
                                                    data-mdb-ripple-color="light">
                                                    @if ($item->item_image == null)
                                                        <div class="container border border-2"
                                                            style="width: 200px; height: 200px; display: flex; justify-content: center; align-items: center;">
                                                            <p style="text-align: center;">No image found.</p>
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('storage/' . $item->item_image) }}" width="200px"
                                                            height="200px">
                                                    @endif
                                                    <div class="">
                                                            <h5>
                                                                <div class="row mx-auto">
                                                                    <div class="col-12">
                                                                        <span class="badge bg-success ms-2">
                                                                            {{Str::limit($item->room->department->department_abbre,25)}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </h5>
                                                        {{-- <div class="row">
                                                            <div class="d-flex justify-content-start align-items-end h-100">
                                                                <div class="col-md-4"></div>
                                                                <span class="bg-success ms-2 col-md-3">
                                                                    {{ $totalquantity - $totalDeduct }}
                                                                </span>
                                                                <div class="col-md-4"></div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="card-body text-center">
                                                    <div class="row mx-auto">
                                                        <span
                                                            class="card-title mb-3 font-weight-bold display-3">{{ $item->brand->brand_name }}</span>
                                                        {{-- <h5 class="card-title mb-3">{{ $item->category->category_name }}</h5> --}}
                                                        <p class="card-title mb-3">{{ Str::limit($item->description,20) }}</p>
                                                    </div>
                                                    <div class="row mx auto">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-link text-success" data-toggle="modal"
                                                            data-target="#itemModal{{ $item->id }}">
                                                            More info <i class="bi bi-search"></i>
                                                            </button>
                                                        
                                                        
                                                            @if($totalquantity - $totalDeduct == 0)
                                                                <button type="button" class="btn btn-link text-danger" disabled>
                                                                Out of Stock
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-link text-success text-sm-end" disabled>
                                                                Available: {{ $totalquantity - $totalDeduct }} pc/s
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
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
                                                                @if($totalquantity - $totalDeduct != 0)
                                                                    <i class="fas fa-cart-plus"></i><input type="submit"
                                                                    class="btn btn-success" value="Add to cart">
                                                                    <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Close</button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Close</button>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                </div>


            </div>
            
        </section>
       

    </div>

@endsection
