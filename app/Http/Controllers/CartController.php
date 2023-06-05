<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Cart;
use App\Models\Department;
use App\Models\User;
use App\Models\Order;
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

            // dd($order);
            $item_temp = new OrderItemTemp;

            $item_temp->order_id = $order->id;
            $item_temp->item_id = $item->id;
            $item_temp->quantity = $request->quantity;

            $item_temp->save();

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

        if($order != null){
            $cartItems = OrderItemTemp::where('order_id',$order->id)->get();
        }else{
            $cartItems = null;

        }
        


        $user_dept_id = Auth::user()->department_id;
       
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

        

        return view('pages.students.cart-list')->with(compact('cartItems','items'));

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
            
            session()->flash('success','Item quantity changed.');
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
        
        $orderHistory = Order::whereNotNull('date_submitted')->whereNotNull('date_returned')->get();

        // dd($orderHistory);

        return view('pages.students.history')->with(compact('orderHistory'));

    }
    
    public function pending(){
        
        $pendingOrder = Order::whereNotNull('date_submitted')->whereNull('date_returned')->get();

        dd($pendingOrder);

        return view('pages.students.pending')->with(compact('pendingOrder'));
    }

    
    
}