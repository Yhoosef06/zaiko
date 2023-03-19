@extends('pages.admin.home')

@section('content')
    <h4>List of Users</h4>
    <div class="content shadow-sm p-2">
        @if ($users->count())
            <table class="table">
                @if (session('status'))
                    <div class="container alert text-center">
                        <h4>{{ session('status') }}</h4>
                    </div>
                @endif
                <form action="{{ route('filtered_view_users') }}" type="get" method="get" role="search">
                    @csrf
                    <div class="input-group mb-3 d-flex flex-row-reverse">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                        <input type="search" class="form-control col-2" name="query" id="query" placeholder="">
                        <a class="btn" href="{{ route('view_users') }}"><svg xmlns="http://www.w3.org/2000/svg"
                                width="18" height="18" fill="currentColor" class="bi bi-repeat" viewBox="0 0 16 16">
                                <path
                                    d="M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192Zm3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z" />
                            </svg></a>
                    </div>
                </form>
                <thead>
                    <tr>
                        <th scope="col">ID #</th>
                        <th scope="col">Name</th>
                        <th scope="col">Account Type</th>
                        <th scope="col">Account Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th>{{ $user->id_number }}</th>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>

                            @if ($user->account_type == 'student')
                                <td>{{ 'Student' }}</td>
                            @else
                                <td>{{ 'Admin' }}</td>
                            @endif


                            {{-- span used for status bg --}}
                            @if ($user->account_status == 'pending')
                                <td><span class="bg-warning p-1 m-1" style="padding:10px">{{ 'Pending' }}</span>
                                </td>
                            @else
                                <td><span class="bg-success p-1 m-1" style="padding:10px">{{ 'Approved' }}</span>
                                </td>
                            @endif

                            {{-- btn user for status bg --}}
                            {{-- @if ($user->account_status == 'pending')
                                <td><span class="btn bg-warning p-1 m-1"
                                        style="padding:10px">{{ $user->account_status }}</span></td>
                            @else
                                <td><span class="btn bg-success p-1 m-1"
                                        style="padding:10px">{{ $user->account_status }}</span></td>
                            @endif --}}

                            <td><a href="{{ route('view_user_info', $user->id_number) }}" class="text-success">View</a>/
                                <a href="{{ route('edit_user_info', $user->id_number) }}">Edit</a>/
                                <form action="{{ route('delete_user', $user->id_number) }}" method="POST"
                                    class="form-check-inline">
                                    @csrf
                                    <button type="submit"
                                        class="border-0 text-danger text-decoration-underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                <h5>{{ $users->links() }}</h5>
            </div>
        @else
            <div class="text-center">
                <form action="{{ route('filtered_view_users') }}" type="get" method="get" role="search">
                    @csrf
                    <div class="input-group mb-3 d-flex flex-row-reverse">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                        <input type="text" class="form-control col-2" name="query" id="query" placeholder="">
                    </div>
                </form>
                Data not found.
            </div>
        @endif
    </div>
@endsection
