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
                    <label for="">Aquisition Date:</label>
                    {{ date('F j, Y', strtotime($item->aquisition_date)) }}
                </div>
                <div>
                    <label for="">Description:</label> {{ $item->description }}
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
                            width="200px" height="200px">
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-title">Logs:</div>
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
    <a href="#" data-toggle="modal" data-target="#modal-edit-user-info"
        onclick="openEditUserModal('{{ $item->id }}')" class="btn btn-primary">Edit</a>
