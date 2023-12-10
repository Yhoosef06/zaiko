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
                            <div class="row">
                                <div class="col-md-4">
                                    <form id="csvForm" method="POST" enctype="multipart/form-data">
                                        {{-- <form action="{{ route('store_csv_file') }}" method="POST" enctype="multipart/form-data"> --}}
                                        @csrf
                                        <label for="csv_file">Add your file here:</label><br>
                                        <input type="file" name="csv_file" id="csv_file" required>
                                        <button type="submit" id="uploadBtton" class="btn bg-olive mt-1">Upload</button>
                                    </form>
                                </div>
                                <div class="col-md-8">
                                    <div id="errorContainer"></div>
                                </div>
                            </div>
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
                    title: 'Uploading CSV File Right Now',
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
                                    Swal.fire('Success', response.success, 'success')
                                        .then(() => {
                                            $('#csv_file').val(
                                                '');
                                        });;
                                } else if (response.error) {
                                    displayError(response.error);
                                }
                            },
                            error: function(xhr, status, error) {
                                var response = xhr.responseJSON;
                                if (response && response.errors && Array.isArray(
                                        response.errors)) {
                                    displayErrorInTable(response.errors);
                                } else if (response && response.error) {
                                    displayError(response.error);
                                } else {
                                    displayError(
                                        'An error occurred while processing the file.'
                                    );
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

        function displayError(message) {
            $('#errorContainer').html('<div>' + message + '</div>');
        }

        function displayErrorInTable(errors) {
            var table =
                '<div class="alert alert-dismissible">' +
                '<div class="error-header">' +
                '<h5><i class="icon fas fa-exclamation-triangle"></i> Error Encountered While Uploading CSV File</h5>' +
                '</div>' +
                '<div class="scrollable-container">' +
                '<table class="table">' +
                '<thead class="sticky-header">' +
                '<tr>' +
                '<th>ID Number</th>' +
                '<th>First Name</th>' +
                '<th>Last Name</th>' +
                '<th>Email Address</th>' +
                '<th>Remark</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

            // Error data rows
            $.each(errors, function(index, error) {
                table += '<tr>' +
                    '<td>' + error[0] + '</td>' +
                    '<td>' + error[1] + '</td>' +
                    '<td>' + error[2] + '</td>' +
                    '<td>' + error[3] + '</td>' +
                    '<td>' + error[4] + '</td>' +
                    '</tr>';
            });

            table += '</tbody></table></div>';

            $('#errorContainer').html(table).addClass('border border-danger');
            
            $('.error-header').css({
                'color': 'red'
            });

            $('.sticky-header').css({
                'position': 'sticky',
                'top': '0',
                'background-color': '#fff',
                'z-index': '1'
            });
        }
    </script>
    <style>
        /* .scrollable-container {
            max-height: 600px;
            overflow-y: auto;
            padding: 10px;
        } */
    </style>
@endsection
