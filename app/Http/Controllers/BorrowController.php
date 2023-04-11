<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
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

    public function remove(Request $request){
        if($request->serial_number){
            // $cart = session()->get('cart');
            // if(isset($cart[$request->serial_number])){
            //     unset($cart[$request->serial_number]);
            //     session()->put('cart',$cart);
            $request->session()->forget($request->serial_number);

            session()->flash('success','Item suceessfully removed.');
            return redirect()->route('student.cart.list')->with('status', 'Item ' . ' removed successfully.');
        }
    }
   


    public function borrowed(){
        $borrows = ORDER::where('order_status', '=', 'borrowed')->get();

        return view('pages.admin.borrowed')->with(compact('borrows'));
    }

    public function pending(){
        $pendings = ORDER::where('order_status', '=', 'pending')->get();

        return view('pages.admin.pending')->with(compact('pendings'));
    }

    public function forReturn(){
        $forReturns = ORDER::where('order_status', '=', 'for return')->get();

        return view('pages.admin.for-return')->with(compact('forReturns'));
    }
}
