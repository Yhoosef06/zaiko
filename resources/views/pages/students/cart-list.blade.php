@extends('layouts.pages.yields')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Items in Cart</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
            <table id="cart" class="table">

                <thead>
                    <tr>
                        <th style="width:10%" class="text-wrap">Category</th>
                        <th style="width:10%" class="text-wrap">Brand</th>
                        <th style="width:10%" class="text-wrap">Model</th>
                        <th style="width:25%" class="text-wrap">Description</th>
                        <th style="width:20%" class="text-wrap text-center">Quantity</th>
                        <th style="width:10%" class="text-wrap text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $cart)
                        
                            <tr>
                               
                                <td class="text-wrap">{{ $cart->item->category->category_name }}</td>
                                <td class="text-wrap">{{ $cart->item->brand }}</td>
                                <td class="text-wrap">{{ $cart->item->model }}</td>
                                <td class="text-wrap">{{ $cart->item->description }}</td>
                                {{-- <td class="text-wrap text-center">
                                    <i class="fa fa-minus" onclick="updateQuantity('{{ $cart->id }}', -1)"></i>
                                    <input type="text" name="" id="" value="{{ $cart->quantity }}">
                                    <i class="fa fa-plus" onclick="updateQuantity('{{ $cart->id }}', 1)"></i>
                                </td> --}}

                                <td class="text-center">
                                    @php 
                                        $catItem = $items->where('category_id',$cart->item->category->id)->sortByDesc('id');
                                        $groupedItems = $catItem->groupBy(function ($item) {
                                            return $item->brand . '_' . $item->model;
                                        });
                                    @endphp
                                    <button class="btn btn-default btn-sm minus-btn">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input id="quantity-input" type="number" value="{{ $cart->quantity }}" min="0"
                                        max="{{ count($catItem) }}">
                                    <button class="btn btn-default btn-sm plus-btn">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                    {{-- <button class="btn btn-danger btn-sm" id="cart_remove"><i class="bi bi-x-circle"></i> Remove</button> --}}
                                <td class="text-center">
                                    <a class="border-0 text-danger text-decoration-underline" onclick="return confirm('Are you sure you want to remove item?')" href="{{ route('remove.cart', $cart->id)}}">Delete</a>
                                </td>
                            </tr>

                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('.plus-btn').click(function(e) {
                                        e.preventDefault();
                                        var input = $('#quantity-input');
                                        var currentValue = parseInt(input.val());
                                        var maxValue = parseInt(input.attr('max'));

                                        if (currentValue < maxValue) {
                                            input.val(currentValue + 1);
                                        }
                                    });

                                    $('.minus-btn').click(function(e) {
                                        e.preventDefault();
                                        var input = $('#quantity-input');
                                        var currentValue = parseInt(input.val());
                                        var minValue = parseInt(input.attr('min'));

                                        if (currentValue > minValue) {
                                            input.val(currentValue - 1);
                                        }
                                    });
                                });
                            </script>

                    @endforeach


                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" class="text-right">
                            <a href="{{ route('student.items') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Continue Browsing Items</a>
                            <a href="{{ route('order.cart') }}" class="btn btn-success" data-toggle="modal" data-target="#itemModal"><i class="fa fa-arrow-right"></i> Borrow Items</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <!-- Modal -->
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
                                        This Borrowing Agreement is made and entered into on <b>{{ date('M d, Y') }}</b> between <b>{{Auth::user()->first_name}} {{ Auth::user()->last_name }}</b> a student of <b>School of Computer Studies</b>, collectively referred to as the "Parties".
                                    </p>
                            
                                    <p>The Lender agrees to lend the Borrower the following DEVICES for educational, which includes but is not limited to managing, tracking, and organizing inventory for the Borrower's business operations. The System may include hardware, software, and any related peripherals or accessories.
                                    </p>
                            
                                    <p><b>Condition of the System:</b> The Borrower acknowledges that the System is being borrowed in its current condition, and the Borrower shall be responsible for using the System in a careful and responsible manner. The Borrower shall also be responsible for returning the System in the same condition, ordinary wear and tear excepted. Any damages or loss to the System during the borrowing period shall be the responsibility of the Borrower, and the Borrower shall reimburse the Lender for the repair or replacement costs.
                                    </p>
                            
                                    <p><b>Duration of Borrowing:</b> The Borrower shall borrow the System for a period of discussed duration, commencing from the Effective Date, unless otherwise agreed upon by both Parties in writing. The Borrower shall promptly return the System to the Lender upon the expiration or termination of the borrowing period, or upon the request of the Lender.
                                    </p>
                            
                                    <p><b>Rights and Obligations:</b> The Borrower shall have the right to use the System solely for the purposes stated in this Agreement, and shall not transfer, lease, sublet, sell, or otherwise dispose of the System to any third party without the prior written consent of the Lender. The Borrower shall also be responsible for maintaining the confidentiality and security of any passwords, access codes, or other security measures associated with the System.
                                    </p>
                            
                                    <p><b>Liability and Indemnity:</b> The Borrower shall be solely responsible for the proper use, operation, and maintenance of the System during the borrowing period, and shall indemnify and hold harmless the Lender from any claims, damages, liabilities, or losses arising out of the use, possession, or transportation of the System, including but not limited to any claims related to data breaches, loss of data, or unauthorized access to the System.
                                    </p>
                            
                                    <p><b>Entire Agreement:</b> This Agreement contains the entire understanding between the Parties with respect to the subject matter hereof and supersedes all prior agreements, understandings, or representations, whether written or oral, relating to the borrowing of the System.
                                    </p>
                            
                                    <p><b>Amendment and Waiver:</b> Any amendment or waiver of this Agreement must be in writing and signed by both Parties. Failure to enforce any provision of this Agreement shall not be deemed a waiver of such provision or any other provision hereof.
                                    </p>
                            
                                    <p><b>Severability:</b> If any provision of this Agreement is found to be invalid, illegal, or unenforceable, the validity, legality, and enforceability of the remaining provisions shall not in any way be affected or impaired.
                                    </p>
                            
                                    <p><b>Binding Effect:</b> This Agreement shall be binding upon and inure to the benefit of the Parties hereto and their respective successors, assigns, and legal representatives.
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
                            {{-- <form action="{{ route('order.cart') }}" method="POST" onsubmit="return confirm('Are you sure you want to borrow items in the cart??');">
                                @csrf
                                <input type="submit" class="btn btn-outline-dark" value="Add to cart" id="addToCartButton" disabled>
                            </form> --}}
                            {{-- <a href="{{ route('order.cart') }}" onclick="return confirm('Are you sure you want to borrow items in cart?')" class="btn btn-outline-dark" id="addToCartButton" disabled><i class="fa fa-arrow-right" ></i> Borrow Items</a> --}}
                            <button type="button" class="btn btn-outline-dark" id="addToCartButton" disabled>
                                <a href="{{ route('order.cart') }}" onclick="return confirm('Are you sure you want to borrow items in cart?')"><i class="fa fa-arrow-right"></i> Borrow Items</a>
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                        <script>
                            const agreementCheckbox = document.getElementById('agreementCheckbox');
                            const addToCartButton = document.getElementById('addToCartButton');
                        
                            agreementCheckbox.addEventListener('change', function() {
                                addToCartButton.disabled = !agreementCheckbox.checked;
                            });
                        </script>
                        
                    </div>
                </div>
            </div>

@endsection
