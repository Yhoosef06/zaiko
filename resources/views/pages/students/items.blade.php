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
                        <form action="{{ route('department') }}" method="POST">
                            @csrf
                            <select class="form-control" id="department" name="department" onchange="this.form.submit()">
                                <option value="" selected>All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            @foreach ($items as $item)
                {{ $item->brand->brand_name }} {{ $item->model->model_name}}
            @endforeach
        </section>
    </div>
    <script>
        $(document).ready(function() {
            // Hide all department content initially
            $('.tab-pane').hide();
    
            // Show the selected department content when the dropdown changes
            $('select#department').change(function() { // Update the selector for the dropdown
                var selectedDepartment = $(this).val();
                $('.tab-pane').hide();
                $('#' + selectedDepartment).show();
    
                // Remove the following lines related to AJAX as they are not necessary for your form submission
                
                // Optionally, you can submit the form when the dropdown changes
                // $('form').submit(); 
            });
    
            // Fetch the selected department from the session and show its corresponding items
            var selectedDepartment = '{{ old('department') }}'; // Update to use old() method
            if (selectedDepartment !== '') {
                $('select#department').val(selectedDepartment);
                $('#' + selectedDepartment).show();
            }
        });
    </script>

@endsection
