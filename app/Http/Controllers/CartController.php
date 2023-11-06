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

class CartController extends Controller
{
    public function add_cart(Request $request, $id){
        
        // dd($id);
        $user = Auth::user(); 
        $item = Item::find($id);

        $order = Order::where('user_id', $user->id_number)->where('date_submitted', null)->first();

        // dd($order);

        if($order == null){
            $order_cart = new Order;

            $order_cart->user_id = $user->id_number;
            $order_cart->save();

            // dd($order_cart->id);

            $item_temp = new OrderItemTemp;

            $item_temp->order_id = $order_cart->id;
            $item_temp->item_id = $item->id;
            $item_temp->quantity = $request->quantity;

            $item_temp->save();

        }else{
            $itemModel = $item->model->model_name;
            // dd($itemModel);

            $itemTemps = OrderItemTemp::where('order_id', $order->id)->get();

            $filteredItems = $itemTemps->filter(function ($itemTemp) use ($itemModel) {
                return $itemTemp->item->model->model_name === $itemModel;
            });
            
            $exists = $filteredItems->isNotEmpty();

            // dd($exists);

            if($exists == false){
                $item_temp = new OrderItemTemp;

                $item_temp->order_id = $order->id;
                $item_temp->item_id = $item->id;
                $item_temp->quantity = $request->quantity;

                $item_temp->save();
            }else{
                $borrowedList= OrderItem::where('status', 'borrowed')->get();
                $missingList = ItemLog::where('mode', 'missing')->get();

                foreach($itemTemps as $itemTemp){
                    if($itemTemp->item->model->model_name == $itemModel){ 
                        // dd($itemTemp->item->model->model_name);
                        if($itemTemp->item->category_id == 5 || $itemTemp->item->category_id == 6 || $itemTemp->item->category_id == 7){
                            // dd($itemTemp->item->quantity);

                            $missingQty = 0;
                            $borrowedQty = 0;
                            $totalDeduct = 0;
                            foreach($borrowedList as $borrowed){                                                        
                                if($borrowed->item_id == $item->id){
                                    $borrowedQty = $borrowedQty + $borrowed->order_quantity;
                                }    
                            }
                
                            foreach ($missingList as $missing) {
                                if($missing->item_id == $itemModel->id){
                                    $missingQty = $missingQty + $missing->quantity;
                                }
                            }
                                    
                
                            $totalDeduct = $missingQty + $borrowedQty;
                
                            // dd($totalDeduct);
                            if($itemTemp->quantity + $request->quantity <= $itemTemp->item->quantity - $totalDeduct){
                                $itemTemp->quantity = $itemTemp->quantity + $request->quantity;
                                // dd($itemTemp->quantity);
                                $itemTemp->save();
                            }        

                        }else{
                            // dd($itemTemp->item);
                            $catItem = $itemTemp->item->where('category_id',$itemTemp->item->category->id)->where('brand_id',$itemTemp->item->brand_id)->where('model_id',$itemTemp->item->model_id)->where('borrowed','no')->count();
                            
                            // dd($catItem);
                            if($itemTemp->quantity + $request->quantity <= $catItem){
                                $itemTemp->quantity = $itemTemp->quantity + $request->quantity;
                                // dd($itemTemp->quantity);
                                $itemTemp->save();
                            }
                        }
                    }else{
                        
                        if($itemTemps == null){
                            $item_temp = new OrderItemTemp;

                            $item_temp->order_id = $order->id;
                            $item_temp->item_id = $item->id;
                            $item_temp->quantity = $request->quantity;

                            $item_temp->save();
                        }
                    }
                    
                }
            }

           
            

            // dd($order);
            // $item_temp = new OrderItemTemp;

            // $item_temp->order_id = $order->id;
            // $item_temp->item_id = $item->id;
            // $item_temp->quantity = $request->quantity;

            // $item_temp->save();

            // dd($item_temp);

        }       


        
        // dd($order_cart);

        // $cart = new Cart;

        // $categoryName = ItemCategory::where('id', $item->category_id)->value('category_name');

        // $cart->id_number = $user->id_number;
        // $cart->category = $categoryName;
        // $cart->brand = $item->brand;
        // $cart->model = $item->model;
        // $cart->item_description = $item->description; 
        // $cart->quantity = $request->quantity;
        // $cart->ordered = 'no';

        // $cart->save();

        // session()->flash('success','Item suceessfully added to cart.');

        return redirect()->back();      
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

        session()->flash('success','Your borrowing order is already in process.. Please go to the SCS office within 1 day to proceed to your borrowing process');          

        return redirect()->route('student.dashboard');
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