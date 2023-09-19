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
                    <div class="card">
                        <div class="card-header">
                            <h3>Setup Security Question</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('store_security_question', ['id_number' => Auth::user()->id_number]) }}"
                            method="POST">
                            @csrf
                            <div class="card-body">
                                <label for="">Password Security Question:</label>
                                <select name="question" id="question"
                                    class="form-control  @error('question') border-danger @enderror">
                                    <option value="">Select a security question</option>
                                    @foreach ($securityQuestions as $question)
                                        <option value="{{ $question->id }}"
                                            {{ old('question') == $question->id ? 'selected' : '' }}>
                                            {{ $question->question }}</option>
                                    @endforeach
                                </select>
                                @error('question')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label for="">Your Answer:</label>
                                <input type="text" value="{{ old('answer') }}"
                                    class="form-control @error('answer') border-danger @enderror" placeholder="Your answer"
                                    name="answer" id="answer" placeholder="Your Answer">
                                @error('answer')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <hr>
                                <Button type="submit" class="btn btn-success"
                                    onclick="return confirm('Do you wish to continue?')">Save & continue</Button>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>
@endsection
