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
        @empty($categories)
        <div id="preloader" class="d-flex align-items-center justify-content-center">
            <div class="spinner">

            </div>
        </div>
        @endempty     

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

            @isset($category)         
           
                <div class="col-3">
                    <form action=""></form>
                    <select class="form-select form-select-lg mb-5" aria-label="Default select example" name="selectedCategory">
                        <option selected value="" disabled>Choose Category</option>
                        @foreach ($categories as $category)
                            <option value="category{{ $category->id }}"
                                {{ old('selectedCategory', session('selectedCategory')) === 'category' . $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endisset

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
        });
    </script>
    
@endsection
