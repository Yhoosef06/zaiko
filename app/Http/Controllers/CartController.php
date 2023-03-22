<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Cart;
use App\Models\User;
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

        $cart->save();

        session()->flash('success','Item suceessfully added to cart.');

        return redirect()->back();      
    }
}
