@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="text-decoration-underline">Adding New {{ Auth::user()->account_type == 'faculty' ? 'Student' : 'User' }}</h1> --}}
                    <h1 class="text-decoration-underline">Uploading CSV File</h1>
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
                                <input type="file" name="csv_file" id="csv_file">
                                <button type="submit" id="uploadBtton" class="btn bg-olive">Upload</button>
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
            document.getElementById('uploadBtton').innerHTML = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Uploading...';
        });
    </script>
    
@endsection
