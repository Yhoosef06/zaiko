@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
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
                            {{-- <form id="csvForm" method="POST" enctype="multipart/form-data"> --}}
                            <form action="{{ route('store_csv_file') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="csv_file">Add your file here:</label><br>
                                <input type="file" name="csv_file" id="csv_file">
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
        $(document).ready(function() {
            $('#csvForm').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                Swal.fire({
                    title: 'Uploading CSV File Right Now.',
                    text: 'Do you wish to continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#uploadBtton').prop('disabled', true).html(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Uploading...'
                        );
                        $.ajax({
                            url: "{{ route('store_csv_file') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Success', response.success, 'success');
                                } else if (response.error) {
                                    if (Array.isArray(response.errors) && response
                                        .errors.length > 0) {
                                        Swal.fire('Error', response.errors.join('<br>'),
                                            'error');
                                    } else if (response.errorCSV) {
                                        Swal.fire('Error', response.error, 'error');
                                    }
                                }
                            },
                            error: function(xhr, status, error) {
                                if (xhr.responseJSON && xhr.responseJSON.errors && xhr
                                    .responseJSON.errors.length > 0) {
                                    Swal.fire('Error', xhr.responseJSON.errors.join(
                                        '<br>'), 'error');
                                } else {
                                    Swal.fire('Error',
                                        response.errors,
                                        'error');
                                }
                            },
                            complete: function() {
                                $('#uploadBtton').prop('disabled', false).html(
                                    'Upload');
                            }
                        });
                    }
                });
            });
        });
    </script>
    <style>
        .scrollable-container {
            border: 1px solid #ccc;
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
        }

        .department-container {
            margin-bottom: 10px;
        }
    </style>
@endsection
