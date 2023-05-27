<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Cart;
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

        $id = Auth::user()->id_number;
        $cart = Cart::where('id_number','=',$id)->get();

        return view('pages.students.cart-list')->with(compact('cart'));

    }

    public function remove_cart($id){
        
        Cart::where('id','=',$id)->delete();

        session()->flash('success','Item suceessfully removed.');
        return redirect()->back();
    }

    public function cart_notif(){

        $id = Auth::user()->id_number;
        $cart = Cart::where('id_number','=',$id)->count();

        
    }

    public function order_cart(){

        $user = Auth::user()->id_number;
        $usernames = Auth::user();

        $data = Cart::where('id_number', '=', $user)->get();

            foreach($data as $data){
                
                // if($data->ordered == 'no'){
                    $order = new Order;
                    $order->id_number = $data->id_number;
                    $order->first_name = $usernames->first_name;
                    $order->last_name = $usernames->last_name;
                    $order->category = $data->category;
                    $order->brand = $data->brand;
                    $order->model = $data->model;
                    $order->item_description = $data->item_description;
                    $order->quantity = $data->quantity;
                    $order->order_status = "pending";
                    
                    // $affectedRows = Item::where('serial_number','=',$data->serial_number)->update(['borrowed' => 'pending']);
                    
                    // dd($order);
                    
                    $order->save();
                    $data->delete();

                    

                    session()->flash('success','Your borrowing order is already in process.. Please go to the SCS office within 1 day to proceed to your borrowing process');
                // }
                // else{
                //     session()->flash('success','You have already submitted a borrow request.');
                //     break;
                    
                // }
               
            }  

        return redirect()->route('student.dashboard');
    }

    
}