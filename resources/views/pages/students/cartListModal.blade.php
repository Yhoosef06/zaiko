@php
    use App\Models\OrderItemTemp;
@endphp

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="cart" class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-success" style="background-color: rgba(0, 150, 0, 0.9) !important;">
                                <th style="width:10%" class="text-wrap">Category</th>
                                <th style="width:10%" class="text-wrap">Brand</th>
                                <th style="width:15%" class="text-wrap">Model</th>
                                <th style="width:35%" class="text-wrap">Description</th>
                                <th style="width:20%" class="text-wrap text-center">Quantity</th>
                                <th style="width:10%" class="text-wrap text-center">Actions</th>
                            </tr>
                        </thead>
                        
                        @php
                            $items = OrderItemTemp::where('order_id',$order->id)->get();
                            // dd($items);
                        @endphp
                        @if($items != null)
                            <tbody>
                                @foreach($items as $item)
                                    <tr style="background-color: rgba(255, 255, 255, 0.8);">
                                            
                                        <td class="text-wrap">{{ $item->item->category->category_name }}</td>
                                        <td class="text-wrap">{{ $item->item->brand->brand_name }}</td>
                                        <td class="text-wrap">{{ $item->item->model->model_name }}</td>
                                        <td class="text-wrap">{{ $item->item->description }}</td>
                                        {{-- <td class="text-wrap text-center">
                                            <i class="fa fa-minus" onclick="updateQuantity('{{ $item->id }}', -1)"></i>
                                            <input type="text" name="" id="" value="{{ $item->quantity }}">
                                            <i class="fa fa-plus" onclick="updateQuantity('{{ $item->id }}', 1)"></i>
                                        </td> --}}
                                        <td class="text-center position-relative">
                                            @php 
                                                $catItem = $items->where('category_id',$item->item->category->id)
                                                ->where('brand',$item->item->brand)
                                                ->where('model',$item->item->model)
                                                ->where('borrowed','no')
                                                ->sortByDesc('id');
                                            @endphp
                                        
                                        <form action="{{ route('cart.update',$item->id) }}" method="POST">
                                        @csrf
                                        
                                                <div class="row">
                                                    <div class="col md-6">
                                                        
                                                        {{-- <select class="form-control" id="quantity" name="quantity" onchange="this.form.submit()">
                                                            @for($i = 1; $i <= $item->quantity-$totalDeduct; $i++)
                                                            <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select> --}}

                                                        {{-- ___________________ --}}
                                                        <select class="form-control" id="quantity" name="quantity" onchange="this.form.submit()">
                                                            @if($item->item->serial_number == null || $item->item->serial_number === 'N/A')
                                                                @php
                                                                $missingQty = 0;
                                                                $borrowedQty = 0;
                                                                $totalDeduct = 0;
                                                                foreach($borrowedList as $borrowed){                                                        
                                                                    if($borrowed->item_id == $item->item->id){
                                                                        $borrowedQty = $borrowedQty + $borrowed->order_quantity;
                                                                    }    
                                                                }

                                                                foreach ($missingList as $missing) {
                                                                    if($missing->item_id == $item->item->id){
                                                                        $missingQty = $missingQty + $missing->quantity;
                                                                    }
                                                                }
                                                                $totalDeduct = $missingQty + $borrowedQty;

                                                                @endphp
                                                                @for($i = 1; $i <= $item->item->quantity-$totalDeduct; $i++)
                                                                    @if($i == $item->quantity)
                                                                        <option value="{{$i}}" selected>{{$i}}</option>
                                                                    @else
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                    @endif
                                                                @endfor
                                                            @elseif($item->item->serial_number != null || $item->item->serial_number !='N/A')
                                                            
                                                                @for($i = 1; $i <= count($catItem); $i++)
                                                                @if($i == $item->quantity)
                                                                    <option value="{{$i}}" selected>{{$i}}</option>
                                                                @else
                                                                    <option value="{{$i}}">{{$i}}</option>
                                                                @endif
                                                                @endfor
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>      
                                        
                                        </form>
                                            {{-- <button class="btn btn-default btn-sm plus-btn">
                                                <i class="fa fa-plus"></i>
                                            </button> --}}
    {{--                                         
                                            <script>
                                                $(document).ready(function() {
                                                $('#quantity').change(function() {
                                                    var selectedQuantity = $(this).val(); // Get the selected value
                                                    
                                                    // Send AJAX request to update the value in the database
                                                    $.ajax({
                                                    url: '{{ route("item.update") }}',
                                                    method: 'POST',
                                                    data: {
                                                        quantity: selectedQuantity
                                                    },
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    success: function(response) {
                                                        // Handle the success response if needed
                                                    },
                                                    error: function(xhr, status, error) {
                                                        // Handle the error if needed
                                                    }
                                                    });
                                                });
                                                });
                                                </script>
                                                --}}
                                                
                                        </td>
                                            {{-- <button class="btn btn-danger btn-sm" id="item_remove"><i class="bi bi-x-circle"></i> Remove</button> --}}
                                        <td class="text-center">
                                            <a class="border-0 text-danger text-decoration-underline" onclick="return confirm('Are you sure you want to remove item?')" href="{{ route('remove.cart', $item->id)}}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
               
            </div>
            <div class="modal-footer">
                @if($items != null)
                    <tr>
                        <td colspan="10" class="text-left">
                            <a href="{{ route('browse.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                            <a href="{{ route('order.cart') }}" class="btn btn-success" data-toggle="modal" data-target="#itemModal"><i class="fa fa-arrow-right"></i> Borrow Items</a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="12" class="text-center">
                            <a href="{{ route('browse.items') }}" class="btn btn-danger"><i class="bi bi-cart-x"></i> No items in cart</a>
                            
                        </td>
                    </tr>
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>