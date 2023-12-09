@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="container">
                            <div class="container pt-4 pb-2 text-center">
                                <h1>Welcome to Zaiko</h1>
                                <div class="border border-dark mx-auto p-4">
                                    <h3>Terms & Conditions</h3>
                                    {!! $agreement->agreement_text ?? '' !!}
                                </div>

                                <div class="mt-3">
                                    <form method="POST" action="{{ route('agreed') }}" class="text-center">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="agreementCheckbox"
                                                name="agreementCheckbox">
                                            <label class="form-check-label" for="agreementCheckbox">
                                                I AGREE
                                            </label>
                                        </div>
                                        <button type="submit" class="btn mt-3 bg-olive" id="submitButton"
                                            disabled>Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submitButton').prop('disabled', true);
            $('#agreementCheckbox').change(function() {
                if (this.checked) {
                    $('#submitButton').prop('disabled',
                        false);
                } else {
                    $('#submitButton').prop('disabled',
                        true);
                }
            });
        });
    </script>
@endsection
