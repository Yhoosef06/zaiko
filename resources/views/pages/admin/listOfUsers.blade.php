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
                        <input type="text" class="form-control col-2" name="query" id="query" placeholder="">
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
                                <a href="{{ route('edit_item_details', $user->id_number) }}">Edit</a>/
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
