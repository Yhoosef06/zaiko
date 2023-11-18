    <div class="container">
        <div class="row">
            <div class="col">
                <div>
                    <label for="">Item ID #:</label> {{ $item->id }}
                </div>
                <div>
                    <label for="">Location:</label> {{ $item->room->room_name }}
                </div>
                <div>
                    <label for="">Category:</label> {{ $item->category->category_name }}
                </div>
                <div>
                    <label for="">Brand:</label>
                    {{ $item->brand_id ? $item->brand->brand_name : 'N/A' }}
                </div>
                <div>
                    <label for="">Model:</label>
                    {{ $item->model_id ? $item->model->model_name : 'N/A' }}
                </div>
                <div>
                    <label for="">Part Number:</label>
                    {{ $item->part_number ? $item->part_number : 'N/A' }}
                </div>
                <div>
                    <label for="">Serial Number:</label>
                    {{ $item->serial_number ? $item->serial_number : 'N/A' }}
                </div>
                <div>
                    <label for="">Quantity:</label> {{ $item->quantity }}
                </div>
                <div>
                    <label for="status">Status:</label> {{ $item->status }}
                </div>
                <div>
                    <label for="">Aquisition Date:</label>
                    {{ date('F j, Y', strtotime($item->aquisition_date)) }}
                </div>
                <div>
                    <label for="">Description:</label> {{ $item->description }}
                </div>
                <div>
                    <label for="">Maximum Borrowing Days:</label> {{ $item->duration }}
                </div>
                <div>
                    <label for="">Overdue Penalty Fee:</label> {{ $item->penalty_fee }}
                </div>
            </div>

            <div class="col">
                <div class="container text-center">
                    @if ($item->item_image == null)
                        <div
                            style="border: 1px solid #000; width: 200px; height: 200px; display: flex; justify-content: center; align-items: center;">
                            No Image
                        </div>
                    @else
                        <img src="{{ asset('storage/' . $item->item_image) }}" alt="" srcset=""
                            width="250px" height="250px">
                    @endif
                </div>
            </div>
            <label for="">Logs:</label>
            <div class="card">
                <div class="card-body" style="max-height:100px; overflow-y: auto;">
                    @forelse ($itemLogs as $itemLog)
                        Date & Time: {{ date('F j, Y H:i:s', strtotime($itemLog->created_at)) }}<br>
                        Mode: {{ $itemLog->mode }} <br>
                        @if ($itemLog->mode == 'transferred')
                            Room From: {{ $itemLog->roomFrom->room_name }} <br>
                            Room To: {{ $itemLog->roomTo->room_name }} <br>
                        @endif
                        @if ($itemLog->mode == 'replacement')
                            Replaced Item: {{ $item->replaced_item }} <br>
                        @endif
                        Encoded By: {{ $itemLog->user->first_name }} {{ $itemLog->user->last_name }}
                        <br>
                        <hr>
                    @empty
                        <div class="text-center">
                            <p>No data.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <hr>
    <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">
        Close
    </button>
    @if (Auth::user()->hasPermission('update-items'))
        <button href="#" data-toggle="modal" data-target="#modal-edit-item"
            onclick="openEditItemModal('{{ $item->id }}')" class="btn btn-primary">Edit</button>
    @endif

    <div class="modal fade" id="modal-edit-item" tabindex="-1" role="dialog" aria-labelledby="modal-edit-item">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-add-sub-item">Editing Item Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form fields for editing the item details -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEditItemModal(itemId) {
            var modal = $('#modal-edit-item');
            var url = "{{ route('edit_item_details', ['id' => ':itemId']) }}".replace(':itemId', itemId);

            // Clear previous content from the modal
            modal.find('.modal-body').html('');

            $.get(url, function(data) {
                modal.find('.modal-body').html(data);
            });
        }
    </script>
