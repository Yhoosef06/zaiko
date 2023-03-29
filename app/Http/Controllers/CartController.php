<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class CartController extends Controller
{
    public function add_cart($id){
        
        $user = Auth::user();

        // $cartcheck = Cart::where('id_number', '=', $user->id_number)->exists();
        
        $item = Item::find($id);

        $cart = new Cart;

        $cart->id_number = $user->id_number;
        $cart->serial_number = $item->serial_number;
        $cart->item_name = $item->item_name;
        $cart->item_description = $item->item_description; 
        $cart->ordered = 'no';

        $cart->save();

        session()->flash('success','Item suceessfully added to cart.');

        return redirect()->back();      
    }

    public function cart_list(){

        $id = Auth::user()->id_number;
        $cart = Cart::where('id_number','=',$id)->get();

        return view('pages.students.cart-list')->with(compact('cart'));

    }

    public function remove_cart($id){
        
        Cart::where('serial_number','=',$id)->delete();

        session()->flash('success','Item suceessfully removed.');
        return redirect()->back();
    }

    public function cart_notif(){

        $id = Auth::user()->id_number;
        $cart = Cart::where('id_number','=',$id)->count();

        
    }

    public function order_cart(){

        $user = Auth::user()->id_number;

        $data = Cart::where('id_number', '=', $user)->get();


            foreach($data as $data){
                if($data->ordered == 'no'){
                    $order = new Order;
    
                    $order->id_number = $data->id_number;
                    $order->serial_number = $data->serial_number;
                    $order->item_name = $data->item_name;
                    $order->item_description = $data->item_description;
                    $order->order_status = "pending";
                    
                    $data->ordered = "yes";
                    
                    $data->update();
                    $order->save();

                    session()->flash('success','Your borrowing order is already in process.. Please go to the SCS office within 1 day to proceed to your borrowing process');
                }else{
                    session()->flash('success','You have already submitted a borrow request.');
                    break;
                    
                }
               
            }

        return redirect()->route('student.dashboard');
    }
}
