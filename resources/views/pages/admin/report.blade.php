@extends('layouts.pages.yields')

@section('content')
    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif
    <div class="col-lg-6 bg-light shadow-sm p-3">
        <label for="adding new item">
            <h1>Generate Inventory Report</h1>
        </label>
        <form action="{{ route('download_pdf', ['download' => 'pdf']) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="location">Room:</label>
                <select id="location" name="location"
                    class="form-control col-sm-3 @error('location')
                    border-danger @enderror">
                    @if (old('location') == true)
                    @foreach ($rooms as $room)
                        @if ($room->id == old('location'))
                        <option value="{{ old('location') }}" selected>{{$room->room_name}}</option>
                        @endif
                    @endforeach
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                        @endforeach
                    @else
                        <option value="option_select" disabled selected>Select a room</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                        @endforeach
                    @endif
                </select>

                @error('location')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">

                <div class="col">

                    <div class="form-group">
                        <label for="prepared_by">Prepared By:</label>
                        <input placeholder="Name of staff/faculty member" type="text" id="prepared_by" name="prepared_by"
                            value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"
                            class="form-control @error('prepared_by')
                                border-danger @enderror">
                        @error('prepared_by')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="verified_by">Verified By:</label>
                        <input placeholder="Name of staff/faculty member" type="text" id="verified_by" name="verified_by"
                            value="{{ old('verified_by') }}"
                            class="form-control @error('verified_by')
                        border-danger @enderror">
                        @error('verified_by')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lab_oic">Noted By:</label>
                        <input placeholder="Name of staff/faculty member" type="text" id="lab_oic" name="lab_oic"
                            value="{{ old('lab_oic') }}"
                            class="form-control @error('lab_oic')
                    border-danger @enderror">
                        @error('lab_oic')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="it_specialist">Approved By:</label>
                        <input placeholder="Name of staff/faculty member" type="text" id="it_specialist"
                            name="it_specialist" value="{{ old('it_specialist') }}"
                            class="form-control @error('it_specialist')
                        border-danger @enderror">
                        @error('it_specialist')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- <label for="Purpose">Purpose:</label>
                    <input type="text" id="purpose" name="purpose"
                        class="form-control @error('purpose')
                    border-danger
                    @enderror"
                        placeholder="Leave blank if none.">
                    @error('purpose')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror --}}

                    {{-- <label for="department">Department / Office:</label>
                    <input placeholder="Name of Department/Office" type="text" id="department" name="department"
                        class="form-control @error('department')
                    border-danger @enderror">
                    @error('department')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror --}}


                </div>
                <div class="col">
                    <label for="positions">Position/Rank/Role:</label>

                    <div class="form-group">
                        <input placeholder="" type="text" id="position_1" name="position_1"
                            value="{{ old('position_1') }}"
                            class="form-control @error('position_1')
                        border-danger @enderror">
                        @error('position_1')
                            <div class="text-danger">
                                {{ 'This field must not be blank.' }}
                            </div>
                        @enderror
                    </div>

                    <label for="">Position/Rank/Role:</label>
                    <div class="form-group">
                        <input placeholder="" type="text" id="position_2" name="position_2"
                            value="{{ old('position_2') }}"
                            class="form-control @error('position_2')
                        border-danger @enderror">
                        @error('position_2')
                            <div class="text-danger">
                                {{ 'This field must not be blank.' }}
                            </div>
                        @enderror
                    </div>

                    <label for="">Position/Rank/Role:</label>
                    <div class="form-group">
                        <input placeholder="" type="text" id="position_3" name="position_3"
                            value="{{ old('position_3') }}"
                            class="form-control @error('position_3')
                        border-danger @enderror">
                        @error('position_3')
                            <div class="text-danger">
                                {{ 'This field must not be blank.' }}
                            </div>
                        @enderror
                    </div>

                    <label for="">Position/Rank/Role:</label>
                    <div class="form-group">
                        <input placeholder="" type="text" id="position_4" name="position_4"
                            value="{{ old('position_4') }}"
                            class="form-control @error('position_4')
                        border-danger @enderror">
                        @error('position_4')
                            <div class="text-danger">
                                {{ 'This field must not be blank.' }}
                            </div>
                        @enderror
                    </div>


                </div>

                <div>
                    <hr>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                    <Button type="submit" class="btn btn-success">Generate</Button>
                </div>
            </div>
        </form>
    </div>
@endsection
