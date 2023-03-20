<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function addToCart($serial_number){
        $item = Item::findOrFail($serial_number);

        $cart = session()->get('cart', []);

        if(isset($cart[$serial_number])){
            $cart[$serial_number]['quantity']++;
        }else{
            $cart[$serial_number] = [
                "item_name" => $item->item_name,
                "item_description" => $item->item_description,
                "unit_number" => $item->unit_number,
                "quantity" => 1
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', "Item added to cart successfully");
    }

    public function cartList(){
        return view('pages.students.cart-list');
    }
}
