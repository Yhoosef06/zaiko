@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-decoration-underline">Generate Inventory Report</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12" style="max-width: 1000px">
                    <div class="card">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('success') }}</p>
                            </div>
                        @elseif (session('danger'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p><i class="icon fas fa-exclamation-triangle"></i>{{ session('danger') }}</p>
                            </div>
                        @endif
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('download_pdf', ['download' => 'pdf']) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <label for="location">Room/Location: </label>
                                <div style="display:flex">
                                    <div>
                                        <select id="location" name="location"
                                            class="form-control @error('location')
                                                    border-danger @enderror">
                                            <option value="option_select" disabled selected>Select a room</option>
                                            @foreach ($rooms as $room)
                                                <option value="{{ $room->id }}"
                                                    {{ old('location') == $room->id ? 'selected' : '' }}>
                                                    {{ $room->room_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('location')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col">

                                        <div class="form-group">
                                            <label for="prepared_by">Prepared By:</label>
                                            <input placeholder="" type="text" id="prepared_by" name="prepared_by"
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
                                            <input placeholder="Enter a name" type="text" id="verified_by"
                                                name="verified_by" value="{{ old('verified_by') }}"
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
                                            <input placeholder="Enter a name" type="text" id="noted_by" name="noted_by"
                                                value="{{ old('noted_by') }}"
                                                class="form-control @error('noted_by')
                                            border-danger @enderror">
                                            @error('noted_by')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="it_specialist">Approved By:</label>
                                            <input placeholder="Enter a name" type="text" id="approved_by"
                                                name="approved_by" value="{{ old('approved_by') }}"
                                                class="form-control @error('approved_by')
                                                border-danger @enderror">
                                            @error('approved_by')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="positions">Position/Role:</label>

                                        <div class="form-group">
                                            <input placeholder="Enter a position/role" type="text" id="role_1"
                                                name="role_1" value="{{ old('role_1') }}"
                                                class="form-control @error('role_1')
                                                border-danger @enderror">
                                            @error('role_1')
                                                <div class="text-danger">
                                                    {{ 'This field must not be blank.' }}
                                                </div>
                                            @enderror
                                        </div>

                                        <label for="">Position/Role:</label>
                                        <div class="form-group">
                                            <input placeholder="Enter a position/role" type="text" id="role_2"
                                                name="role_2" value="{{ old('role_2') }}"
                                                class="form-control @error('role_2')
                                                border-danger @enderror"
                                                placeholder="Enter a name">
                                            @error('role_2')
                                                <div class="text-danger">
                                                    {{ 'This field must not be blank.' }}
                                                </div>
                                            @enderror
                                        </div>

                                        <label for="">Position/Role:</label>
                                        <div class="form-group">
                                            <input placeholder="Enter a position/role" type="text" id="role_3"
                                                name="role_3" value="{{ old('role_3') }}"
                                                class="form-control @error('role_3')
                                                border-danger @enderror"
                                                placeholder="Enter a name">
                                            @error('role_3')
                                                <div class="text-danger">
                                                    {{ 'This field must not be blank.' }}
                                                </div>
                                            @enderror
                                        </div>

                                        <label for="">Position/Role:</label>
                                        <div class="form-group">
                                            <input placeholder="Enter a position/role" type="text" id="role_4"
                                                name="role_4" value="{{ old('role_4') }}"
                                                class="form-control @error('role_4')
                                                border-danger @enderror"
                                                placeholder="Enter a name">
                                            @error('role_4')
                                                <div class="text-danger">
                                                    {{ 'This field must not be blank.' }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <hr>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Cancel</a>
                                <Button type="submit" class="btn btn-dark">Generate</Button>
                                <Button type="button" id="saveReferencesBtn" class="btn btn-info">Save
                                    References</Button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

    @if (session('status'))
        <div class="container alert text-center text-success">
            <h4>{{ session('status') }}</h4>
        </div>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#saveReferencesBtn').click(function(event) {
                event.preventDefault();

                var formData = $('form').serialize();

                var button = $(this);

                $.ajax({
                    url: '{{ route('store_references') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        button.after(
                            '<span class="m-1"><i class="fa fa-check text-green"></i></span>'
                        );

                        button.attr('class', 'btn btn-outline-info').prop('disabled', true);;
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        if (xhr.status === 422) {
                            $('#location').addClass('border-danger');
                            $('#prepared_by').addClass('border-danger');
                            $('#noted_by').addClass('border-danger');
                            $('#verified_by').addClass('border-danger');
                            $('#approved_by').addClass('border-danger');
                            $('#role_1').addClass('border-danger');
                            $('#role_2').addClass('border-danger');
                            $('#role_3').addClass('border-danger');
                            $('#role_4').addClass('border-danger');
                            alert('Make sure that there are no empty fields.');
                        }
                    }
                });
            });
        });

        $(document).ready(function() {

            function fetchAndPopulateData(location) {
                $.ajax({
                    url: 'get-references',
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        location: location
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.length > 0) {

                            response.sort(function(a, b) {
                                return new Date(b.created_at) - new Date(a.created_at);
                            });

                            var latestData = response[
                                0];

                            $('#prepared_by').val(latestData.prepared_by);
                            $('#verified_by').val(latestData.verified_by);
                            $('#noted_by').val(latestData.noted_by);
                            $('#approved_by').val(latestData.approved_by);
                            $('#role_1').val(latestData.role_1);
                            $('#role_2').val(latestData.role_2);
                            $('#role_3').val(latestData.role_3);
                            $('#role_4').val(latestData.role_4);
                        }

                        $('#saveReferencesBtn').attr('class', 'btn btn-info').prop('disabled', false);
                        $('#saveReferencesBtn').next('span').remove();
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                    }
                });
            }

            $('#location').change(function() {
                console.log('Change event triggered');
                var selectedLocation = $(this).val();
                if (selectedLocation) {
                    fetchAndPopulateData(selectedLocation);
                }
            });
        });
    </script>
@endsection
