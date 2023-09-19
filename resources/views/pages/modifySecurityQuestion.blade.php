@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- Adding distance from the top navigation bar --}}
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12" style="max-width: 500px">
                    <div class="card text-lg p-3">
                        <div class="card-title">
                            <H3>Updating Security Question</H3>
                        </div>
                        <form class="form-signin"
                            action="{{ route('save_modified_security_question', ['id_number' => Auth::user()->id_number]) }}"
                            method="POST" enctype="multipart/form-data">
                            
                            @csrf

                            <label for="">Question</label>
                            <select name="question" id="question"
                                class="form-control @error('question') border-danger @enderror">
                                <option value="{{ $questions->id }}" selected>{{ $questions->question }}</option>
                                @foreach ($securityQuestions as $question)
                                    <option value="{{ $question->id }}">{{ $question->question }}</option>
                                @endforeach
                            </select>

                            <label for="">Answer:</label>
                            <input type="" name="answer" id="answer"
                                class="form-control @error('answer') border-danger @enderror"
                                value="{{ Auth::user()->answer }}" placeholder="Your answer">

                            <hr>
                            <a href="{{ route('view_profile', ['id_number' => Auth::user()->id_number]) }}"
                                class="btn btn-outline-dark">Back</a>
                            <Button type="submit" class="btn btn-success"
                                onclick="return confirm('You are about to modify your security question. Do you wish to continue?')">Save Changes</Button>
                        </form>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        </div>
    </section>
@endsection
