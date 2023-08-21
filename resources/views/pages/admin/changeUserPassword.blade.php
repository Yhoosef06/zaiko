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
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Change Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start --> 
                        @if (Auth::user()->id_number == $user->id_number)
                        <form action="{{ route('save_user_new_password', ['id_number' =>  Auth::user()->id_number]) }}" method="POST">
                        @else
                        <form action="{{ route('save_user_new_password', ['id_number' =>  $user->id_number]) }}" method="POST">
                        @endif
                            
                            @csrf
                            <div class="card-body">
                                <label for="">New Password:</label>
                                <input type="password" name="new_password" id="new_password"
                                    class="form-control password @error('new_password') border-danger @enderror"
                                    placeholder="New Password">
                                @error('new_password')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label for="">Confirm Password:</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control password @error('password_confirmation') border-danger @enderror"
                                    placeholder="Confirm Password">
                                @error('password_confirmation')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <hr>
                                @if ($user->id_number == Auth::user()->id_number)
                                    <a href="{{ route('view_profile', ['id_number' => Auth::user()->id_number]) }}" class="btn btn-outline-dark">Back</a>
                                @else
                                <a href="{{ route('view_users', ['id_number' => $user->id_number]) }}" class="btn btn-outline-dark">Back</a>
                                @endif
                               
                                <Button type="submit" class="btn btn-success"  onclick="return confirm('Do you wish to continue changing your password?')">Save</Button>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>
@endsection
