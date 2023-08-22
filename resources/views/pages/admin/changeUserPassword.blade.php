<form action="{{ route('save_user_new_password', ['id_number' => $user->id_number]) }}" method="POST">
    @csrf
    <div class="card-body">
        <label for="">New Password:</label>
        <input type="password" name="new_password" id="new_password"
            class="form-control password @error('new_password') border-danger @enderror" placeholder="New Password">
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
        <button type="button" class="btn btn-dark" data-dismiss="modal">
           Cancel
        </button>
        <Button type="submit" class="btn btn-success"
            onclick="return confirm('Do you wish to continue changing your password?')">Save</Button>
    </div>
    <!-- /.card-body -->
</form>
