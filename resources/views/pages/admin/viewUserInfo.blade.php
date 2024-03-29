<div class="container p-2">
    <strong>I.D. Number:</strong> {{ $user->id_number }} <br>
    <strong>First Name:</strong> {{ $user->first_name }} <br>
    <strong>Last Name:</strong> {{ $user->last_name }} <br>
    <strong>Email Address:</strong> {{ $user->email ? $user->email : 'None' }} <br>
    @if ($user->departments->isNotEmpty())
        <strong>Department(s) associated to:</strong>
        @foreach ($user->departments as $key => $department)
            {{ $department->department_name }}
            @if ($key < count($user->departments) - 1)
                ,
            @endif
        @endforeach
        <br>
    @endif
    <strong>Account Type:</strong>
    {{ $user->account_type === 'student' ? 'Student' : ($user->account_type === 'admin' ? 'Admin' : ($user->account_type === 'faculty' ? 'Faculty' : 'Faculty')) }}
    <br>
    <strong>Status:</strong>
    {{ $user->isActive ? 'Active' : 'Inactive' }}
    <br>
    <strong>Role:</strong>
    @foreach ($user->roles as $role)
        {{ $role->name === 'manager' ? 'Manager' : 'Borrower' }}
    @endforeach
    <br>
    @if ($user->isActive == false)
        <strong>Last Enrolled Semester:</strong>
        @foreach ($terms as $term)
            @if ($term->id == $user->term_id)
                {{ $term->semester }} {{ date('Y', strtotime($term->start_date)) }} -
                {{ date('Y', strtotime($term->end_date . ' +1 year')) }}
            @endif
        @endforeach
    @endif
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    @if (Auth::user()->hasPermission('update-users'))
        <a href="#" data-toggle="modal" data-target="#modal-edit-user-info"
            onclick="openEditUserModal('{{ $user->id_number }}')" class="btn btn-primary">Edit</a>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="modal-edit-user-info" tabindex="-1" role="dialog" aria-labelledby="modal-edit-user-info">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-edit-user-info">Edit
                    {{-- {{ Auth::user()->account_type == 'faculty' ? 'Student' : 'User' }} Information --}}
                    User Information
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script>
    function openEditUserModal(userId) {
        var modal = $('#modal-edit-user-info');
        var url = "{{ route('edit_user_info', ['id_number' => ':userId']) }}".replace(':userId', userId);

        // Clear previous content from the modal
        modal.find('.modal-body').html('');

        $.get(url, function(data) {
            modal.find('.modal-body').html(data);
        });
    }
</script>
