@extends('layouts.pages.yields')

@section('content')
    <div class="col-lg-4 bg-light shadow-sm p-3">
        <label for="adding new item">
            <h1>Add a Room</h1>
        </label>
        <form action="{{ route('store_new_room') }}" method="POST">
            @csrf
            <br>
            <label for="">Room Name:</label>
            <input type="text" name="room_name" id="room_name"
                class="form-control password @error('room_name') border-danger @enderror" placeholder="Room name">
            @error('room_name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            @if (session('message'))
                <div class="text-danger">
                    {{ session('message') }}
                </div>
            @endif
            <hr>
            <a href="{{ route('add_item') }}" class="btn btn-outline-dark">Back</a>
            <Button type="submit" class="btn btn-success">Save</Button>
        </form>
    </div>
@endsection
