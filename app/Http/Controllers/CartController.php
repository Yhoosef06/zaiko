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


        $borrowedList= OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();

        
        $user_department = UserDepartment::where('user_id_number', $user->id_number)->first();

        $user_dept_id = $user_department->department_id;
        $departments = Department::with('college')->get();
   

        $cartItems =collect();
        foreach($orders as $order){
            $cartItemsCollect = OrderItemTemp::where('order_id',$order->id)->get();
            $cartItems = $cartItems->merge($cartItemsCollect);
        }

        $items = collect();
        $cartDepartment = null;
        foreach($orders as $order){
            $cartDepartment = $cartItems->where('order_id',$order->id)->first()->item->room->department->id;
            $itemsCollect = Item::whereHas('room.department', function ($query) use ($cartDepartment) {
                    $query->where('id', $cartDepartment)->where('borrowed','no');
                })->get();
            $items = $items->merge($itemsCollect);
        }
              
        return view('pages.students.cartList')->with(compact('orders','cartItems','items','borrowedList','missingList'));

    }   

    public function browse_cart($id){

        $user = Auth::user(); 
        $borrowedList= OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();

        $cartItems = OrderItemTemp::where('order_id',$id)->get();
        
        $user_department = UserDepartment::where('user_id_number', $user->id_number)->first();

        $user_dept_id = $user_department->department_id;
        $departments = Department::with('college')->get();
        $departmentID = $cartItems->first()->item->room->department->id;

        $items = Item::whereHas('room.department', function ($query) use ($departmentID) {
            $query->where('id', $departmentID)->where('borrowed','no');
        })->get();
        return view('pages.students.cart-list')->with(compact('cartItems','items','borrowedList','missingList'));

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

    public function remove_transaction($id){
        
        Order::where('id',$id)->delete();

        session()->flash('success','Transaction suceessfully cancelled.');
        return redirect()->back();
    }

    public function update_cart(Request $request,$id){
 
       
        $item = OrderItemTemp::find($id);
        
            $item->quantity = $request->quantity;
            $item->save();
            
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
        
        $releasedOrders = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNotNull('approval_date')->get();
        $orderItems =collect();
        $items = collect();
        
        foreach($releasedOrders as $order){
            $orderItemsCollect = OrderItem::where('order_id',$order->id)->whereIn('status',['returned','lost'])->get();
            $orderItems = $orderItems->merge($orderItemsCollect);
        }

        foreach($orderItems as $orderItem){
            $itemsCollect = Item::where('id',$orderItem->item_id)->get();
            $items = $items->merge($itemsCollect);
        }

        return view('pages.students.history')->with(compact('releasedOrders','orderItems','items'));

    }
    
    public function pending(){
        
        $user = Auth::user(); 
        $orders = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNull('date_returned')->whereNull('approval_date')->get();
        $items = collect();
        
        foreach($orders as $order){

            $orderItemTemps = OrderItemTemp::where('order_id', $order->id)->get();
            $items = $items->merge($orderItemTemps);
        }
       
        return view('pages.students.pending')->with(compact('orders','items'));
    }

    public function borrowed(){

        $releasedOrders = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNotNull('approval_date')->whereNull('date_returned')->get();
        $orderItems =collect();
        $items = collect();
        
        foreach($releasedOrders as $order){
            $orderItemsCollect = OrderItem::where('order_id',$order->id)->where('status','borrowed')->get();
            $orderItems = $orderItems->merge($orderItemsCollect);
        }

        foreach($orderItems as $orderItem){
            $itemsCollect = Item::where('id',$orderItem->item_id)->get();
            $items = $items->merge($itemsCollect);
        }

            
        return view('pages.students.borrowed')->with(compact('releasedOrders','orderItems','items'));
    }

    
    
}