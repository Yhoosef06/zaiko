@extends('pages.admin.home')

@section('content')
    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="container col-lg-5 bg-light shadow-sm p-3">
        <label for="adding new item">
            <h1>Generate Inventory Report</h1>
        </label>
        <form action="{{ route('download_pdf', ['download'=>'pdf']) }}" method="POST">
            @csrf
            <div class="container">
                <div class="wrapper p-3">
                    <label for="location">Room / Location:</label>
                    <select id="location" name="location"
                        class="form-control col-sm-5 @error('location')
                        border-danger @enderror">
                        <option value="option_select" disabled selected>Select a location</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->room_name }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>

                    @error('location')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="Purpose">Purpose:</label>
                    <input type="text" id="purpose" name="purpose"
                        class="form-control @error('purpose')
                    border-danger
                    @enderror"
                        placeholder="Purpose of the report">
                    @error('purpose')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="department">Department / Office:</label>
                    <input value="School of Computer Studies" type="text" id="department" name="department"
                        class="form-control @error('department')
                    border-danger @enderror">
                    @error('department')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <hr>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                    <Button type="submit" class="btn btn-success">Generate</Button>
                </div>
            </div>
        </form>
    </div>
@endsection
