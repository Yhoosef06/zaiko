<div class="container p-2">
    <strong>I.D. Number:</strong> {{ $user->id_number }} <br>
    <strong>First Name:</strong> {{ $user->first_name }} <br>
    <strong>Last Name:</strong> {{ $user->last_name }} <br>
    <strong>Program/Department:</strong> {{ $user->departments->department_name }} <br>
    <strong>Account Type:</strong>
    {{ $user->account_type === 'student' ? 'Student' : ($user->account_type === 'admin' ? 'Admin' : ($user->account_type === 'faculty' ? 'Faculty' : 'Reads')) }}
    <br>
    <strong>Status:</strong>
    {{ $user->account_status === 'pending' ? 'Pending' : 'Approved' }}
    <br>
    <strong>Role:</strong>
    {{ $user->role === 'borrower' ? 'Borrower' : 'Manager' }}
    <br>
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    <a href="#" data-toggle="modal" data-target="#modal-edit-user-info"
        onclick="openEditUserModal('{{ $user->id_number }}')" class="btn btn-primary">Edit</a>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-edit-user-info" tabindex="-1" role="dialog"
    aria-labelledby="modal-edit-user-info">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-edit-user-info">Edit User Information</h4>
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
