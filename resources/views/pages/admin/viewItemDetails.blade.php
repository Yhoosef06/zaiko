    <div class="container">
        <div class="row">
            <div class="col">
                <div>
                    <label for="">Item ID #:</label> {{ $item->id }}
                </div>
                <div>
                    <label for="">Category:</label> {{ $item->category->category_name }}
                </div>
                <div>
                    <label for="">Brand:</label>
                    @if ($item->brand_id)
                        {{ $item->brand->brand_name }}
                    @else
                        N/A
                    @endif
                </div>
                <div>
                    <label for="">Model:</label>
                    @if ($item->model_id)
                        {{ $item->model->model_name }}
                    @else
                        N/A
                    @endif
                </div>
                <div>
                    <label for="">Part Number:</label>
                    @if ($item->part_number)
                        {{ $item->part_number }}
                    @else
                        N/A
                    @endif

                </div>
                <div>
                    <label for="">Serial Number:</label>
                    @if ($item->serial_number)
                        {{ $item->serial_number }}
                    @else
                        N/A
                    @endif
                </div>
                <div>
                    <label for="">Aquisition Date:</label> {{ $item->aquisition_date }}
                </div>
                <div>
                    <label for="">Quantity:</label> {{ $item->quantity }}
                </div>
                <div>
                    <label for="">Description:</label> {{ $item->description }}
                </div>

            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Logs
                    </div>
                    <div class=" card-body">
                        <p>
                            Added by:
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <div class="container text-center">
            @if ($item->item_image == null)
                <img alt="" srcset="" width="200px" height="150px" style="border: 5px">
            @else
                <img src="{{ $item->item_image }}" alt="" srcset="" width="200px" height="100px">
            @endif
        </div>
    </div>
    {{-- <a href="#" data-toggle="modal" data-target="#modal-edit-user-info"
        onclick="openEditUserModal('{{ $user->id_number }}')" class="btn btn-primary">Edit</a> --}}
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>


    <!-- Modal -->
    {{-- <div class="modal fade" id="modal-edit-user-info" tabindex="-1" role="dialog" aria-labelledby="modal-edit-user-info">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-edit-user-info">Edit
                    {{ Auth::user()->account_type == 'faculty' ? 'Student' : 'User' }} Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div> --}}

    {{-- <script>
    function openEditUserModal(userId) {
        var modal = $('#modal-edit-user-info');
        var url = "{{ route('edit_user_info', ['id_number' => ':userId']) }}".replace(':userId', userId);

        // Clear previous content from the modal
        modal.find('.modal-body').html('');

        $.get(url, function(data) {
            modal.find('.modal-body').html(data);
        });
    }
</script> --}}
