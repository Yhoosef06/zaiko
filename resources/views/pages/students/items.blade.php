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
                                    $catItem = $items
                                        ->where('category_id', $category->id)
                                        ->where('borrowed', 'no')
                                        ->sortByDesc('id');
                                    $groupedItems = $catItem->groupBy(function ($item) {
                                        return $item->brand . '_' . $item->model;
                                    });
                                @endphp

                                @foreach ($groupedItems as $groupedItem)
                                    @php
                                        $item = $groupedItem->first();
                                        $serialquantity = $groupedItem->count();
                                        // echo $quantity;
                                    @endphp
                                    <div class="col-lg-2 col-6">
                                        <div class="small-box bg-warning bg-gradient">
                                            <div class="inner">
                                                <h3>{{ $item->brand->brand_name }}</h3>
                                                <p>{{ Str::limit($item->model->model_name, 30, '...') }}</p>
                                            </div>
                                            <div class="small-box-footer d-grid gap-2">
                                                <button type="button" class="btn btn-link text-dark" data-toggle="modal"
                                                    data-target="#itemModal{{ $item->id }}">
                                                    More info <i class="fas fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="itemModal{{ $item->id }}" tabindex="-1"
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







{{-- <div class="m-4"> --}}
{{-- <ul class="nav nav-tabs" id="myTab">
                    @foreach ($categories as $category)
                        <li class="nav-item"> 
                            <a href="#category{{$category->id}}" class="nav-link @if ($loop->first) active @endif" data-toggle="tab">{{$category->category_name}}</a>
                        </li>
                    @endforeach
                </ul> --}}
{{-- <select class="form-select" aria-label="Default select example">
                    <option selected>Choose a Category</option>
                    @foreach ($categories as $category)
                        <option value="category{{$category->id}}">{{$category->category_name}}</option>
                    @endforeach
                </select> --}}

{{-- <div class="form-select">
                    @foreach ($categories as $category)
                    <div class="tab-pane" id="category{{$category->id}}">
                        test
                        <div class="row">
                            @php 
                                $catItem = $items->where('category_id',$category->id)->sortByDesc('id');
                            @endphp
                            @foreach ($catItem as $item)
                                <div class="col-lg-2 col-6">
                                    <div class="small-box bg-info bg-gradient">
                                        <div class="inner">
                                            <h3>{{$item->brand}}</h3>
            
                                            <p>{{Str::limit($item->model, 30, '...')}}</p>
                                        </div>
                                        <div class="small-box-footer d-grid gap-2">
                                            <button type="button" class="btn btn-link text-dark" data-toggle="modal" data-target="#itemModal{{$item->id}}">
                                                More info <i class="fas fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="itemModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="itemModal{{$item->id}}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header text-dark">
                                                    <h5 class="modal-title" id="itemModal{{$item->id}}Label">{{$category->category_name}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body text-dark">
                                                    <div class="row text-lg">
                                                        <div class="col">
                                                            <strong>Brand:</strong> {{ $item->brand }} <br>
                                                            <strong>Model:</strong> {{ $item->model }} <br>
                                                        </div>
                                        
                                                        <div class="col">
                                                            <strong>Description:</strong> {{ $item->description }} <br>
                                                            <strong>Status:</strong> {{ $item->status }}
                                                        </div>
                                                    </div>
                                                    
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('add.cart',$item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to add this item to your cart?');">
                                                            @csrf
                                                            <input type="submit" class="btn btn-outline-dark" value="Add to cart">
                                                        </form>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                </div> --}}

{{-- <script>
                    $(document).ready(function() {
                    // Get the select element
                    var select = $(".form-select");

                    // Add an event listener to the select element
                    select.on("change", function() {
                        // Get the selected option
                        var option = $(this).find("option:selected");

                        // Get the corresponding div
                        var div = $("#" + option.val());

                        // Show the div
                        div.show();
                    });
                    });
                </script>
            </div> 
            //MAO NI LAST DIRI NA CODE
        </section> --}}
{{-- <div class="tab-pane fade show active" id="all">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                @foreach ($items as $item)
                                    <div class="col-lg-2 col-6">
                                        <div class="small-box bg-info bg-gradient">
                                            <div class="inner">
                                                <h3>{{$item->brand}}</h3>
                
                                                <p>{{Str::limit($item->model, 30, '...')}}</p>
                                            </div>
                                            <div class="small-box-footer d-grid gap-2">
                                                <button type="button" class="btn btn-link text-dark" data-toggle="modal" data-target="#itemModal{{$item->id}}">
                                                    More info <i class="fas fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="itemModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="itemModal{{$item->id}}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-dark">
                                                        <h5 class="modal-title" id="itemModal{{$item->id}}Label">ITEM</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body text-dark">
                                                        <div class="row text-lg">
                                                            <div class="col">
                                                                <strong>Item Brand:</strong> {{ $item->brand }} <br>
                                                                <strong>Item Model:</strong> {{ $item->model }} <br>
                                                            </div>
                                            
                                                            <div class="col">
                                                                <strong>Item Description:</strong> {{ $item->description }} <br>
                                                                <strong>Status:</strong> {{ $item->status }}
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('add.cart',$item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to add this item to your cart?');">
                                                                @csrf
                                                                <input type="submit" class="btn btn-outline-dark" value="Add to cart">
                                                            </form>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div> --}}

{{-- <ul class="nav nav-tabs" id="myTab">
                    @foreach ($categories as $category)
                        <li class="nav-item"> 
                            <a href="#{{$category->id}}" class="nav-link" data-category="{{$category->id}}">{{$category->category_name}}</a>
                        </li>
                    @endforeach
                </ul> --}}
{{-- <div class="tab-content"> --}}
{{-- @foreach ($categories as $category)
                        <div class="tab-pane" id="{{$category->id}}">
                            <div class="container-fluid">
                                <div class="row">
                                    @foreach ($items->where('item_category', $category->category_name)->where('borrowed', 'no') as $item)
                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-info bg-gradient">
                                                    <div class="inner">
                                                        <h3>{{$item->brand}}</h3>
                        
                                                        <p>{{Str::limit($item->model, 30, '...')}}</p>
                                                    </div>
                                                    <div class="small-box-footer d-grid gap-2">
                                                        <button type="button" class="btn btn-link text-dark" data-toggle="modal" data-target="#itemModal{{$item->serial_number}}">
                                                            More info <i class="fas fa-arrow-circle-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="itemModal{{$item->serial_number}}" tabindex="-1" role="dialog" aria-labelledby="itemModal{{$item->serial_number}}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="itemModal{{$item->serial_number}}Label">{{$item->item_name}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <div class="row text-lg">
                                                            <div class="col">
                                                                <strong>Item Name:</strong> {{ $item->item_name }} <br>
                                                                <strong>Unit Number:</strong> {{ $item->unit_number }} <br>
                                                                <strong>Location:</strong> {{ $item->location }} <br>
                                                            </div>
                                            
                                                            <div class="col">
                                                                <strong>Item Description:</strong> {{ $item->item_description }} <br>
                                                                <strong>Status:</strong> {{ $item->status }}
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('add.cart',$item->serial_number) }}" method="POST" onsubmit="return confirm('Are you sure you want to add this item to your cart?');">
                                                                @csrf
                                                                <input type="submit" class="btn btn-outline-dark" value="Add to cart">
                                                            </form>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach --}}

{{-- <div class="tab-pane fade show active" id="pc">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                @foreach ($items as $item)
                                    @if ($item->item_name == 'PC')
                                        @if ($item->borrowed == 'no')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-info bg-gradient">
                                                <div class="inner">
                                                    <h3>{{ $item->unit_number }}</h3>

                                                    <p>{{ Str::limit($item->item_description, 30, '...') }}</p>
                                                </div>
                                                <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                    class="small-box-footer">More info <i
                                                        class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="laptop">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            @foreach ($items as $item)
                                @if ($item->item_category == 'Monitor')
                                    @if ($item->borrowed == 'no')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-success bg-gradient">
                                                <div class="inner">
                                                    <h3>{{ $item->unit_number }}</h3>

                                                    <p>{{ Str::limit($item->item_description, 30, '...') }}</p>
                                                </div>
                                                <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                    class="small-box-footer">More info <i
                                                        class="fas fa-arrow-circle-right"></i></a>

                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="phone">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            @foreach ($items as $item)
                                @if ($item->item_name == 'Mouse')
                                    @if ($item->borrowed == 'no')
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-danger bg-gradient">
                                                <div class="inner">
                                                    <h3>{{ $item->unit_number }}</h3>

                                                    <p>{{ Str::limit($item->item_description, 30, '...') }}</p>
                                                </div>
                                                <a href="{{ route('student.view.item', $item->serial_number) }}"
                                                    class="small-box-footer">More info <i
                                                        class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div> --}}
{{-- </div> --}}





{{-- <li class="nav-item">
                        <a href="#pc" class="nav-link active" data-bs-toggle="tab">PC</a>
                    </li>
                    <li class="nav-item">
                        <a href="#laptop" class="nav-link" data-bs-toggle="tab">Laptop</a>
                    </li>
                    <li class="nav-item">
                        <a href="#phone" class="nav-link" data-bs-toggle="tab">Phone</a>
                    </li> --}}
