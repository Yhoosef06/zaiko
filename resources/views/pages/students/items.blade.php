@extends('layouts.pages.yields')


@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('plugins/preloader.css') }}"> --}}
    <div class="borrower-bg borrower-page-height container-fluid pl-5">
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
        {{-- IF NO CATEGORY SELECTED SHOW ALL ITEMS. --}}
            <div class="">
                <div class="row">
                    <div class="col-3">
                        <form action=" {{route('browse.department') }}" method="GET">
                            @csrf
                            <select class="form-select form-select-lg mb-5" aria-label="Default select example" name="selectedDepartment" onchange="this.form.submit()">
                                <option selected value="" disabled>Choose Department</option>
                                @foreach ($departments as $dept)
                                    <option value=" {{ $dept->id}} " {{ Session::get('department') == $dept->id ? 'selected' : '' }}>
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
                        {{-- I VERTICAL LIST NI SIYA SA LEFT SIDE RADIO BUTTON OKAY --}}
                        <form action="{{route('browse.category')}}" method="GET">
                            @csrf
                            @foreach($categories as $cat)
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="category" id="category" value="{{$cat->id}}" {{ Session::get('category') == $cat->id ? 'checked' : '' }}  onclick="this.form.submit()">
                                    <label for="category" class="form-check-label">
                                        {{ $cat->category_name }}
                                    </label>
                                </div>
                            @endforeach
                        </form>
                        @endisset
                    </div>
                    <div class="col-9">
                        @isset($items)
                            <div class="row">
                                @foreach($items as $item)
                                
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="card">
                                            <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
                                                data-mdb-ripple-color="light">
                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/img%20(4).webp"
                                                class="w-100" />
                                                <a href="#!">
                                                <div class="mask">
                                                    <div class="d-flex justify-content-start align-items-end h-100">
                                                    <h5><span class="badge bg-success ms-2">Pcs</span></h5>
                                                    </div>
                                                </div>
                                                <div class="hover-overlay">
                                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                                </div>
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <a href="" class="text-reset">
                                                <h5 class="card-title mb-3">{{ $item->brand->brand_name}}</h5>
                                                </a>
                                                <a href="" class="text-reset">
                                                    <h5 class="card-title mb-3">{{ $item->model->model_name}}</h5>
                                                    </a>
                                                <a href="" class="text-reset" >
                                                <p>Category</p>
                                                </a>
                                                <h6 class="mb-3">$61.99</h6>
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
