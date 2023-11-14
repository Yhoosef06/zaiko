@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">Adding New {{ Auth::user()->account_type == 'faculty' ? 'Student' : 'User' }}</h1> --}}
                    <h1 class="text-decoration-underline">Upload CSV File</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- <div id="loader" class="spinner-border text-primary" role="status" style="display: none;">
                                <span class="sr-only">Loading...</span>
                            </div> --}}
                            <div>
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                                    </div>
                                @elseif (session('danger'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                                    </div>
                                @endif
                            </div>
                            <form id="csvForm" action="{{ route('store_csv_file') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <label for="csv_file">Add your file here:</label><br>
                                <input type="file" name="csv_file" id="csv_file"><br>
                                <label for="Item name">Select a department(s):</label><br>
                                <div class="scrollable-container">
                                    @foreach ($departments->groupBy('college_name') as $collegeName => $departmentsGroup)
                                        <h5 class="text-decoration-underline">
                                            <input type="checkbox" class="college-checkbox" data-college="{{ $collegeName }}">
                                            {{ $collegeName }}
                                        </h5>
                                        <div class="department-container">
                                            @foreach ($departmentsGroup as $department)
                                                <input type="checkbox" class="department-checkbox" name="department_ids[]"
                                                       data-college="{{ $collegeName }}" value="{{ $department->id }}">
                                                {{ $department->department_name }}<br>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                                <button type="submit" id="uploadBtton" class="btn bg-olive mt-1">Upload</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    <script>
        document.getElementById('csvForm').addEventListener('submit', function() {
            // Show the spinner and disable the button when the form is submitted
            document.getElementById('uploadBtton').disabled = true;
            document.getElementById('uploadBtton').innerHTML =
                '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Uploading...';
        });

        $(document).ready(function() {
            $('.college-checkbox').change(function() {
                var collegeName = $(this).data('college');
                var isChecked = $(this).prop('checked');

                $('.department-checkbox[data-college="' + collegeName + '"]').prop('checked', isChecked);
            });

            // Update the college checkbox state based on department checkboxes
            $('.department-checkbox').change(function() {
                var collegeName = $(this).data('college');
                var departmentCheckboxes = $('.department-checkbox[data-college="' + collegeName + '"]');
                var collegeCheckbox = $('.college-checkbox[data-college="' + collegeName + '"]');

                collegeCheckbox.prop('checked', departmentCheckboxes.length === departmentCheckboxes.filter(
                    ':checked').length);
            });
        });

        document.getElementById('department').addEventListener('click', function() {
            document.getElementById('checkbox-container').style.display = 'block';
        });
    </script>
    <style>
        .scrollable-container {
            border: 1px solid #ccc;
            /* Border style */
            max-height: 300px;
            /* Set the maximum height for the scrollable container */
            overflow-y: auto;
            /* Enable vertical scroll when content exceeds the container height */
            padding: 10px;
            /* Optional padding for better appearance */
        }

        .department-container {
            /* If you want to add some space between college groups, you can add margin-bottom here */
            margin-bottom: 10px;
        }
    </style>
@endsection
