@extends('layouts.pages.yields')


@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/preloader.css') }}">
    <div class="borrower-bg borrower-page-height">
        <div class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </div>
        {{-- <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Borrowing</h1>
                    </div>
                </div>
            </div>
        </div> --}}
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
        <section class="content py-5">
            <div class="row">
                <div class="col-6">
                    <div class="container-fluid mt-20 ml-2">
                            <select class="form-control" id="department" name="department" onchange="getDepartment(event)">
                                <option value=""  {{ old('department') == '' ? 'selected' : '' }} disabled>Choose Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
            </div>
           
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row">
                    <div class="col">
                        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center" id="displayData">
                            {{-- The JavaScript function will handle rendering the data here --}}
                        </div>
                    </div>
                    
                </div>
                
            </div>   
            
        </section>
    </div>
    

@endsection
