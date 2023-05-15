<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\ItemCategory;
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

        $categoryName = ItemCategory::where('id', $item->category_id)->value('category_name');

        $cart->id_number = $user->id_number;
        $cart->category = $categoryName;
        $cart->brand = $item->brand;
        $cart->model = $item->model;
        $cart->item_description = $item->description; 
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

        if(($usernames->agreement == true)){
            foreach($data as $data){
                
                // if($data->ordered == 'no'){
                    $order = new Order;
                    $order->id_number = $data->id_number;
                    $order->first_name = $usernames->first_name;
                    $order->last_name = $usernames->last_name;
                    $order->serial_number = $data->serial_number;
                    $order->item_name = $data->item_name;
                    $order->item_description = $data->item_description;
                    $order->order_status = "pending";
                    
                    $affectedRows = Item::where('serial_number','=',$data->serial_number)->update(['borrowed' => 'pending']);
                    
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
        }else{
            return redirect()->route('agreement');
        }

           

        return redirect()->route('student.dashboard');
    }

    
}