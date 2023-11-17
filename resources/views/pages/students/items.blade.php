@extends('layouts.pages.yields')


@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('plugins/preloader.css') }}"> --}}
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
            <div>
                <div class="row">
                    <div class="col-3">
                        <form action=" {{route('browse.department') }}" method="GET">
                            @csrf
                            <select class="form-select form-select-lg mb-5" aria-label="Default select example" name="selectedDepartment" onchange="this.form.submit()">
                                <option selected value="" disabled>Choose Department</option>
                                @foreach ($departments as $dept)
                                    <option value=" {{ $dept->id}} "
                                        {{ old('selectedDepartment', session('selectedDepartment')) ===  $dept->id ? 'selected' : '' }}>
                                        {{ $dept->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <form action="">
                            <select class="form-select form-select-lg mb-5" aria-label="Default select example" name="selectedCategory">
                                <option selected value="" disabled>Choose Category</option>
                                @foreach ($categories as $category)
                                    <option value="category{{ $category->id }}"
                                        {{ old('selectedCategory', session('selectedCategory')) === 'category' . $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="col-9">
                        test
                    </div>
                </div>
    

            </div>
        </section>

    </div>
    
@endsection
