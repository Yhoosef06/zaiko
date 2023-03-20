@extends('pages.admin.home')

@section('content')
    <div class="col-lg-4 bg-light shadow-sm p-3">
        <label for="adding new item">
            <h1>Change Password</h1>
        </label>
        <form action="{{route('save_user_new_password', $user->id_number)}}" method="POST">
            @csrf
            <br>
            <label for="">Password</label>
            <input type="password" name="new_password" id="new_password"
                class="form-control password @error('password') border-danger @enderror" placeholder="Password">
            @error('password')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror

            <label for="">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="form-control password @error('password_confirmation') border-danger @enderror"
                placeholder="Confirm Password">
            @error('password_confirmation')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror

            <hr>
            <a href="{{ route('view_users') }}" class="btn btn-outline-dark">Cancel</a>
            <Button type="submit" class="btn btn-success">Save</Button>
        </form>
    </div>
@endsection
