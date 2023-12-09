@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Agreement Text</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <form method="POST" id="agreementForm">
                @csrf
                <div class="card-body">
                    <textarea class="form-control" id="agreement_text" name="agreement_text"> 
                        {{ $agreement->agreement_text ?? '' }}
                    </textarea>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#agreement_text'))
            .catch(error => {
                console.error(error);
            });

        $(document).ready(function() {
            console.log("Document is ready!");
            $('#agreementForm').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to save changes?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('button[type="submit"]').prop('disabled', true).html(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Saving...'
                        );
                        $.ajax({
                            url: "{{ route('agreement_store') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Success', response.message, 'success')
                                        .then(() => {
                                            location.reload();
                                        });
                                } else {
                                    displayError('An unknown error occurred.');
                                }
                            },
                            error: function(xhr, status, error) {
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    var errors = xhr.responseJSON.errors;
                                    var errorMessage = Object.values(errors).flat()
                                        .join('<br>');
                                    Swal.fire('Error', errorMessage, 'error').then(
                                        () => {
                                            // Adjust the action after error, like a reload
                                            location.reload();
                                        });
                                } else {
                                    displayError(
                                        'An error occurred while processing the request'
                                    );
                                }
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection
