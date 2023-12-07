@extends('layouts.pages.yields')

@section('content-header')
    
@endsection

@section('content')
<div class="borrower-bg borrower-page-height">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Carts By Department</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card" style="background-color: rgba(255, 255, 255, 0.8);">
            <div class="card-body">
                @if (count($orders) != 0)
                    @foreach($orders as $order)
                        @php
                            $foritem = $cartItems->where('order_id',$order->id)->first();
                        @endphp
                        <div class="container h-100 py-5">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-1 card-header">
                                        <h3 class="fw-normal mb-0 text-black">Transaction #{{$order->id}} - {{$foritem->item->room->department->department_name}}</h3>
                                    </div>
                                    @foreach($cartItems as $cartItem)
                                        @php 
                                            $groupedItem = $items->groupBy(function ($item) use ($cartItem) {
                                                return $item->category_id . $item->brand_id . $item->model_id;
                                            })->filter(function ($group) use ($cartItem) {
                                                return $group->where('category_id', $cartItem->item->category->id)
                                                            ->where('brand_id', $cartItem->item->brand_id)
                                                            ->where('model_id', $cartItem->item->model_id)
                                                            ->where('borrowed', 'no')
                                                            ->isNotEmpty();
                                            });
                                            $totalquantity = 0;                                            
                                            if (count($groupedItem) != 0) {
                                                foreach ($groupedItem as $group) {
                                                    foreach ($group as $item) {
                                                        $totalquantity += $item->quantity;
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if($cartItem->order_id == $order->id)
                                            <div class="card  rounded-3 mb-1">
                                                <div class="card-body p-2">
                                                    <div class="row d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            @if ($cartItem->item->item_image == null)
                                                            <div class="img-fluid rounded-3"
                                                                style="border: 1px solid #000; height: 150px; display: flex; justify-content: center; align-items: center;">
                                                                <p>No image found.</p>
                                                            </div>
                                                            @else
                                                                <img src="{{ asset('storage/' . $cartItem->item->item_image) }}"
                                                                    alt="" srcset="" class="img-fluid rounded-3">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            <p class="lead fw-normal mb-2">{{ $cartItem->item->brand->brand_name }}</p>
                                                            <p><span class="text-muted"> {{ $cartItem->item->model->model_name }} </span></p>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            <p><span class="text-muted"> {{ $cartItem->item->description }} </span></p>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex"> 
                                                            <form action="{{ route('cart.update',$cartItem->id) }}" method="POST">
                                                                @csrf
                                                                    
                                                                
                                                                    <select class="form-control text-center" id="quantity" name="quantity" onchange="this.form.submit()">
            
                                                                        @php
                                                                        $missingQty = 0;
                                                                        $borrowedQty = 0;
                                                                        $totalDeduct = 0;
                                                                        foreach ($borrowedList as $borrowed) {
                                                                            if ($borrowed->item_id == $item->id) {
                                                                                $borrowedQty = $borrowedQty + $borrowed->order_quantity;
                                                                            }
                                                                        }
            
                                                                        foreach ($missingList as $missing) {
                                                                            if ($missing->item_id == $item->id) {
                                                                                $missingQty = $missingQty + $missing->quantity;
                                                                            }
                                                                        }
                                                                        $totalDeduct = $missingQty + $borrowedQty;
            
                                                                        @endphp
                                                                        @for ($i = 1; $i <= $totalquantity - $totalDeduct; $i++)
                                                                            @if($i == $cartItem->quantity)
                                                                                <option value="{{$i}}" selected>{{$i}} pc/pcs</option>
                                                                            @else
                                                                                <option value="{{$i}}">{{$i}} pc/pcs</option>
                                                                            @endif
                                                                        @endfor
                                                                    </select>
                                                            </form>     
                                                        </div>  
                                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">                          
                                                            <a class="border-0 text-danger text-decoration-underline" onclick="return showSweetAlert('{{ route('remove.cart', $cartItem->id)}}')" href="#">Remove</a>        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="card">
                                        <a href="{{ route('order.cart') }}" class="btn btn-success" data-toggle="modal" data-target="#itemModal"><i class="fa fa-arrow-right"></i> Borrow Items</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="container h-100 py-5">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="text-center">
                                @if($orders != null)
                                <tr>
                                    <td colspan="10" class="text-left">
                                        <a href="{{ route('browse.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                                    </td>
                                </tr>
                                @else
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <a href="{{ route('browse.items') }}" class="btn btn-danger"><i class="bi bi-cart-x"></i> No items in cart</a>
                                        </td>
                                    </tr>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="modal fade bd-example-modal-xl" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header text-dark">
                    <h5 class="modal-title" id="itemModalLabel"><b>Borrowing Agreement</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-dark">
                    <div class="container">
                        <div class="container-fluid px-5 text-justify">
                            <div class="border border-success rounded px-5 py-5">
                                <p>
                                    This Borrowing Agreement is made and entered into on <b>{{ date('M d, Y') }}</b>
                                    between <b>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</b> a
                                    student of <b>School of Computer Studies</b>, collectively referred to as the
                                    "Parties".
                                </p>

                                <p>The Lender agrees to lend the Borrower the following DEVICES for educational, which
                                    includes but is not limited to managing, tracking, and organizing inventory for the
                                    Borrower's business operations. The System may include hardware, software, and any
                                    related peripherals or accessories.
                                </p>

                                <p><b>Condition of the System:</b> The Borrower acknowledges that the System is being
                                    borrowed in its current condition, and the Borrower shall be responsible for using
                                    the System in a careful and responsible manner. The Borrower shall also be
                                    responsible for returning the System in the same condition, ordinary wear and tear
                                    excepted. Any damages or loss to the System during the borrowing period shall be the
                                    responsibility of the Borrower, and the Borrower shall reimburse the Lender for the
                                    repair or replacement costs.
                                </p>

                                <p><b>Duration of Borrowing:</b> The Borrower shall borrow the System for a period of
                                    discussed duration, commencing from the Effective Date, unless otherwise agreed upon
                                    by both Parties in writing. The Borrower shall promptly return the System to the
                                    Lender upon the expiration or termination of the borrowing period, or upon the
                                    request of the Lender.
                                </p>

                                <p><b>Rights and Obligations:</b> The Borrower shall have the right to use the System
                                    solely for the purposes stated in this Agreement, and shall not transfer, lease,
                                    sublet, sell, or otherwise dispose of the System to any third party without the
                                    prior written consent of the Lender. The Borrower shall also be responsible for
                                    maintaining the confidentiality and security of any passwords, access codes, or
                                    other security measures associated with the System.
                                </p>

                                <p><b>Liability and Indemnity:</b> The Borrower shall be solely responsible for the
                                    proper use, operation, and maintenance of the System during the borrowing period,
                                    and shall indemnify and hold harmless the Lender from any claims, damages,
                                    liabilities, or losses arising out of the use, possession, or transportation of the
                                    System, including but not limited to any claims related to data breaches, loss of
                                    data, or unauthorized access to the System.
                                </p>

                                <p><b>Entire Agreement:</b> This Agreement contains the entire understanding between the
                                    Parties with respect to the subject matter hereof and supersedes all prior
                                    agreements, understandings, or representations, whether written or oral, relating to
                                    the borrowing of the System.
                                </p>

                                <p><b>Amendment and Waiver:</b> Any amendment or waiver of this Agreement must be in
                                    writing and signed by both Parties. Failure to enforce any provision of this
                                    Agreement shall not be deemed a waiver of such provision or any other provision
                                    hereof.
                                </p>

                                <p><b>Severability:</b> If any provision of this Agreement is found to be invalid,
                                    illegal, or unenforceable, the validity, legality, and enforceability of the
                                    remaining provisions shall not in any way be affected or impaired.
                                </p>

                                <p><b>Binding Effect:</b> This Agreement shall be binding upon and inure to the benefit
                                    of the Parties hereto and their respective successors, assigns, and legal
                                    representatives.
                                </p>

                                <p><b>IN WITNESS WHEREOF</b>, the Parties have executed this</p>
                            </div>

                            <div class="row text-center py-5">
                                <div class="col-2 ml-auto">
                                    <div class="form-check border p-2 custom-checkbox">
                                        <input class="form-check-input" type="checkbox" id="agreementCheckbox">
                                        <label class="form-check-label" for="agreementCheckbox"><b>I AGREE</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" id="addToCartButton" disabled>
                        <a onclick="return showSweetOrder('{{ route('order.cart')}}')" href="#">
                            <i class="fa fa-arrow-right"></i> 
                            Proceed
                        </a>
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

                <script>
                    const agreementCheckbox = document.getElementById('agreementCheckbox');
                    const addToCartButton = document.getElementById('addToCartButton');

                    agreementCheckbox.addEventListener('change', function() {
                        addToCartButton.disabled = !agreementCheckbox.checked;
                    });

                    function showSweetAlert(removeUrl) {
                        Swal.fire({
                            title: "Are you sure you want to remove the list?",
                            showDenyButton: true,
                            // showCancelButton: true,
                            confirmButtonText: "Yes, remove it",
                            denyButtonText: `No, cancel`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // If the user clicks "Yes, remove it", navigate to the remove URL
                                Swal.fire({
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1500,
                                title: "Successfully Removed!",
                                icon: "success"
                            }).then(() => {
                                window.location.href = removeUrl;
                            });
                               
                            } else if (result.isDenied) {
                                Swal.fire("Action canceled", "", "info");
                            }
                        });

                        // Prevent the default link behavior
                        return false;
                    }

                    function showSweetOrder(orderSubmit) {
                        Swal.fire({
                            title: "Are you sure you want to proceed the transaction?",
                            showDenyButton: true,
                            // showCancelButton: true,
                            confirmButtonText: "Yes, proceed",
                            denyButtonText: `No, cancel`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // If the user clicks "Yes, remove it", navigate to the remove URL
                                Swal.fire({
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1500,
                                title: "Success!",
                                icon: "success"
                            }).then(() => {
                                window.location.href = orderSubmit;
                            });
                               
                            } else if (result.isDenied) {
                                Swal.fire("Action canceled", "", "info");
                            }
                        });

                        // Prevent the default link behavior
                        return false;
                    }

                </script>
                

            </div>
        </div>
    </div>
</div>

@endsection