<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Cart;
use App\Models\Department;
use App\Models\UserDepartment;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ItemLog;
use App\Models\ItemCategory;
use App\Models\OrderItemTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

use function PHPUnit\Framework\isEmpty;

class CartController extends Controller
{
    public function add_cart(Request $request, $id){
        
        $user = Auth::user(); 
        $item = Item::find($id);
        $department = $item->room->department->id;

        $orders = Order::where('user_id', $user->id_number)->where('date_submitted', null)->get();

        if($orders->isEmpty()){
            //no order id yet
            $order_cart = new Order;

            $order_cart->user_id = $user->id_number;
            $order_cart->save();

            $item_temp = new OrderItemTemp;

            $item_temp->order_id = $order_cart->id;
            $item_temp->item_id = $item->id;
            $item_temp->quantity = $request->quantity;

            $item_temp->save();

        }else{
            $orderchecker = 0;
            foreach($orders as $order){

                $itemModel = $item->model->model_name;
                $itemTemps = OrderItemTemp::where('order_id', $order->id)->get();

                $filteredItems = $itemTemps->filter(function ($itemTemp) use ($itemModel) {
                    return $itemTemp->item->model->model_name === $itemModel;
                });
                
                //check the department of the item
                if($order->orderItemTemp->first()->item->room->department->id == $department){
                    $orderchecker ++;
                    if($filteredItems->isEmpty()){
                        //added item not in order yet
                        $item_temp = new OrderItemTemp;

                        $item_temp->order_id = $order->id;
                        $item_temp->item_id = $item->id;
                        $item_temp->quantity = $request->quantity;

                        $item_temp->save();
                    }else{
                        //added item not yet in order
                        $borrowedList= OrderItem::where('status', 'borrowed')->get();
                        $missingList = ItemLog::where('mode', 'missing')->get();

                        foreach($itemTemps as $itemTemp){
                            //if item is the same with the current looped item
                            if($itemTemp->item->model->model_name == $itemModel){

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

                                //check if quantity does not exceed the available quantity
                                if($itemTemp->quantity + $request->quantity <= $itemTemp->item->quantity - $totalDeduct){
                                    $itemTemp->quantity = $itemTemp->quantity + $request->quantity;
                                    $itemTemp->save();
                                }       
                            }
                        }


                    }
                    


                }

            }
            //item is not in any order yet or no existing department order
            if($orderchecker == 0){
                $order_cart = new Order;

                $order_cart->user_id = $user->id_number;
                $order_cart->save();

                $item_temp = new OrderItemTemp;

                $item_temp->order_id = $order_cart->id;
                $item_temp->item_id = $item->id;
                $item_temp->quantity = $request->quantity;

                $item_temp->save();
            }         
        }       

        return redirect()->back();      
    }

    public function browse(){

        $user = Auth::user(); 
        $orders = Order::where('user_id', $user->id_number)->where('date_submitted', null)->get();
        $itemTemps = OrderItemTemp::all();

        $allOrderItems = collect(); // Create an empty collection

        foreach ($orders as $order) {
            $itemTemps = OrderItemTemp::where('order_id', $order->id)->get();
            $allOrderItems = $allOrderItems->merge($itemTemps);
        }
        dd($allOrderItems);
        
       
        return view('pages.students.cartList')->with(compact('orders'));

    }   



    public function cart_list(){

        $user = Auth::user(); 
        $order = Order::where('user_id', $user->id_number)->where('date_submitted', null)->first();
        $borrowedList= OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();

        if($order != null){
            $cartItems = OrderItemTemp::where('order_id',$order->id)->get();
        }else{
            $cartItems = null;

        }
        

        $user_department = UserDepartment::where('user_id_number', $user->id_number)->first();
        // dd($user_department->department_id);

        $user_dept_id = $user_department->department_id;
        $departments = Department::with('college')->get();
    
        $collegeId = null;
        foreach ($departments as $department) {
            if ($department->id == $user_dept_id) {
                $collegeId =  $department->college->id;
                break;
            }
        }
       
        $items = Item::whereHas('room.department.college', function ($query) use ($collegeId) {
            $query->where('id', $collegeId);
        })->get();
       
        return view('pages.students.cart-list')->with(compact('cartItems','items','borrowedList','missingList'));

    }

    public function remove_cart($id){
        
        OrderItemTemp::where('id','=',$id)->delete();

        session()->flash('success','Item suceessfully removed.');
        return redirect()->back();
    }

    public function update_cart(Request $request,$id){
        // dd($id);
       
        $item = OrderItemTemp::find($id); // Replace $cartId with the actual cart ID
        
            $item->quantity = $request->quantity;
            $item->save();
            
            // session()->flash('success','Item quantity changed.');
            return redirect()->back();
        
    }


    public function cart_notif(){

        $id = Auth::user()->id_number;
        $cart = Cart::where('id_number','=',$id)->count();

        
    }

    public function order_cart(){

        $user = Auth::user()->id_number;
        $usernames = Auth::user();
    

        // $data = Order::where('order', $user)->get();
        $order = Order::where('user_id', $user)->where('date_submitted', null)->first();
        
        
        $order->date_submitted = now();
        $order->save();

        session()->flash('success','Your borrowing order is already in process.. Please go to the department borrowed within 1 day to proceed to your borrowing process');          

        return redirect()->route('borrower.dashboard');
    }

    public function history(){
        
        $orderHistory = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNotNull('date_returned')->get();

        // dd($orderHistory);

        return view('pages.students.history')->with(compact('orderHistory'));

    }
    
    public function pending(){
        
        $pendingOrder = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNull('date_returned')->whereNull('approval_date')->get();

        // dd($pendingOrder);
        return view('pages.students.pending')->with(compact('pendingOrder'));
    }

    public function borrowed(){
        
        $borrowedItems = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNotNull('approval_date')->whereNull('date_returned')->get();
        // dd($borrowedItems);
      
        return view('pages.students.borrowed')->with(compact('borrowedItems'));
    }

    
    
}