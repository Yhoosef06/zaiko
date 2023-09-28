@extends('layouts.pages.yields')


@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/preloader.css') }}">
    <div class="borrower-bg borrower-page-height">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Borrowing</h1>
                    </div>
                </div>
            </div>
        </div>
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

        <script>
            $(window).on('load', function() {
                // Remove the preloader and show the content section when the page is fully loaded
                $('#preloader').fadeOut('slow', function() {
                    $(this).remove(); // Remove the preloader element from the DOM
                    $('.content').fadeIn('slow');
                });
            });
        </script>

 
        <section class="content">
            <div id="categoryContainer">
                <div class="col-3">
                    <select class="form-select form-select-lg mb-5" aria-label="Default select example"
                        name="selectedCategory">
                        <option selected>Choose a Category</option>
                        @foreach ($categories as $category)
                            <option value="category{{ $category->id }}"
                                {{ old('selectedCategory', session('selectedCategory')) === 'category' . $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-20 ml-2">
                    @foreach ($categories as $category)
                        <div class="tab-pane" id="category{{ $category->id }}">
                            <div class="row">
                                @php
                                    $catItem = $items->where('category_id', $category->id)->where('borrowed', 'no');
                                    $groupedItems = $catItem->groupBy(function ($item){
                                        return $item->brand . " " . $item->model;
                                    });
                                    // echo '<pre>';
                                    // print_r($groupedItems);
                                    // echo '</pre>';
                                @endphp

                                @foreach ($groupedItems as $groupedItem)
                                    @php
                                        $item = $groupedItem->first();
                                        if($item->serial_number != 'N/A' || $item->serial_number != null){
                                            $serialquantity = $groupedItem->count();
                                        }
                                        // echo $serialquantity;
                                    @endphp
                                    <div class="col-lg-2 col-6">
                                        <div class="small-box bg-warning bg-gradient">
                                            <div class="inner">
                                                <h3>{{ $item->brand->brand_name }}</h3>
                                                <p>{{ Str::limit($item->model->model_name, 20, '...') }}</p>
                                            </div>
                                            <div class="small-box-footer d-grid gap-2">
                                                <button type="button" class="btn btn-link text-dark" data-toggle="modal"
                                                    data-target="#itemModal{{ $item->id }}">
                                                    More info <i class="fas fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="itemModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="itemModalLabel">Item Information</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                                            alt="" srcset="" width="200px"
                                                                            height="200px">
                                                                    @endif
                                                                    <strong>Brand:</strong> {{ $item->brand->brand_name }}
                                                                    <br>
                                                                    <strong>Model:</strong> {{ $item->model->model_name }}
                                                                    <br>
                                                                    @if ($item->serial_number != 'N/A' || $item->serial_number != null)
                                                                        <strong>Available:</strong>{{ $serialquantity }}
                                                                        <br>
                                                                    @endif
                                                                    @if($item->serial_number == 'N/A' || $item->serial_number == null)
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
                                                                        {{ $item->quantity - $totalDeduct }} <br>
                                                                    @endif
                                                                </div>
                                                                <div class="col">
                                                                    <strong>Description:</strong> {{ $item->description }}
                                                                    <br>
                                                                    <strong>Status:</strong> {{ $item->status }} {{ $item->serial_number}}
                                                                </div>
                                                            </div>
                                                            <form action="{{ route('add.cart', $item->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to add this item to your cart?');">
                                                                @csrf
                                                                <label for="quantity">Quantity:</label>
                                                                <div class="form-group col-2">
                                                               
                                                                        <select class="form-control" id="quantity"
                                                                            name="quantity">
                                                                            @if ($item->serial_number != 'N/A' || $item->serial_number != null)
                                                                                @for ($i = 1; $i <= $serialquantity; $i++)
                                                                                    <option value="{{ $i }}">
                                                                                        {{ $i }}</option>
                                                                                @endfor
                                                                            @endif

                                                                            @if ($item->serial_number == 'N/A' || $item->serial_number == null)
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
                                                                                @for ($i = 1; $i <= $item->quantity - $totalDeduct; $i++)
                                                                                    <option value="{{ $i }}">
                                                                                        {{ $i }}</option>
                                                                                @endfor
                                                                            @endif
                                                                        </select>
         
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <i class="fas fa-cart-plus"></i><input type="submit"
                                                                        class="btn btn-outline-dark" value="Add to cart">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                            
                                                            <!-- Add your item information here -->
                                                            <!-- You can display item details or any other content here -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Hide all category content initially
            $('.tab-pane').hide();

            // Show the selected category content when the dropdown changes
            $('select.form-select').change(function() {
                var selectedCategory = $(this).val();
                $('.tab-pane').hide();
                $('#' + selectedCategory).show();

                // Store the selected option value in the session
                $.ajax({
                    url: '{{ route('storeSelectedCategory') }}',
                    type: 'POST',
                    data: {
                        selectedCategory: selectedCategory,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Session value stored successfully
                    }
                });
            });

            // Fetch the selected category from the session and show its corresponding items
            var selectedCategory = '{{ session('selectedCategory') }}';
            if (selectedCategory !== '') {
                $('select.form-select').val(selectedCategory);
                $('#' + selectedCategory).show();
            }
        });
    </script>
@endsection



{{-- @if ($item->serial_number == null)
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
<select class="form-control" id="quantity"
    name="quantity">
    @for ($i = 1; $i <= $item->quantity - $totalDeduct; $i++)
        <option value="{{ $i }}">
            {{ $i }}</option>
    @endfor
</select>
@endif --}}


{{-- MODAL  --}}
{{-- <div class="modal fade" id="itemModal{{ $item->id }}" tabindex="-1"
    role="dialog" aria-labelledby="itemModal{{ $item->id }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-dark">
                <h5 class="modal-title" id="itemModal{{ $item->id }}Label">
                    {{ $category->category_name }}</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <div class="row text-lg">
                    <div class="col">
                        @if ($item->item_image == null)
                            <div
                                style="border: 1px solid #000; width: 200px; height: 200px; display: flex; justify-content: center; align-items: center;">
                                No Image
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $item->item_image) }}"
                                alt="" srcset="" width="200px"
                                height="200px">
                        @endif
                        <strong>Brand:</strong> {{ $item->brand->brand_name }}
                        <br>
                        <strong>Model:</strong> {{ $item->model->model_name }}
                        <br>
                        @if ($item->category_id != 5 && $item->category_id != 6 && $item->category_id != 7)
                            <strong>Available:</strong>{{ $serialquantity }}
                            <br>
                        @elseif($item->serial_number == null || ($item->category_id = 5 || ($item->category_id = 6 || ($item->category_id = 7))))
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
                            {{ $item->quantity - $totalDeduct }} <br>
                        @endif
                    </div>
                    <div class="col">
                        <strong>Description:</strong> {{ $item->description }}
                        <br>
                        <strong>Status:</strong> {{ $item->status }}
                    </div>
                </div>
                <form action="{{ route('add.cart', $item->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to add this item to your cart?');">
                    @csrf
                    <label for="quantity">Quantity:</label>
                    <div class="form-group col-2">
                        @if ($item->category_id != 5 && $item->category_id != 6 && $item->category_id != 7)
                            <select class="form-control" id="quantity"
                                name="quantity">
                                @for ($i = 1; $i <= $serialquantity; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        @endif
                        @if ($item->category_id == 5 || $item->category_id == 6 || $item->category_id == 7 )
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
                            <select class="form-control" id="quantity"
                                name="quantity">
                                @for ($i = 1; $i <= $item->quantity - $totalDeduct; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <i class="fas fa-cart-plus"></i><input type="submit"
                            class="btn btn-outline-dark" value="Add to cart">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}