<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class BorrowController extends Controller
{
    

    // public function addToCart($serial_number){
    //     $item = Item::findOrFail($serial_number);

    //     $cart = session()->get('cart', []);

    //     if(isset($cart[$serial_number])){
    //         $cart[$serial_number]['quantity']++;
    //     }else{
    //         $cart[$serial_number] = [
    //             "item_name" => $item->item_name,
    //             "item_description" => $item->item_description,
    //             "unit_number" => $item->unit_number,
    //             "quantity" => 1
    //         ];
    //     }
    //     session()->put('cart', $cart);
    //     return redirect()->back()->with('success', "Item added to cart successfully");
    // }

    // public function cartList(){
    //     return view('pages.students.cart-list');
    // }

    // public function remove(Request $request){
    //     if($request->serial_number){
    //         // $cart = session()->get('cart');
    //         // if(isset($cart[$request->serial_number])){
    //         //     unset($cart[$request->serial_number]);
    //         //     session()->put('cart',$cart);
    //         $request->session()->forget($request->serial_number);

    //         session()->flash('success','Item suceessfully removed.');
    //         return redirect()->route('student.cart.list')->with('status', 'Item ' . ' removed successfully.');
    //     }
    // }
   


    public function borrowed(){
        $borrows = ORDER::where('order_status', '=', 'borrowed')->get();

        return view('pages.admin.borrowed')->with(compact('borrows'));
    }

    public function pending(){
        $pc = ITEM:: where('item_category', '=', 'PCs') ->get();
        $monitors = ITEM:: where('item_category', '=', 'Monitors') ->get();
        $mobileDevs = ITEM:: where('item_category', '=', 'Mobile Devices') ->get();
        $peripherals = ITEM:: where('item_category', '=', 'Peripherals') ->get();
        $microControllers = ITEM:: where('item_category', '=', 'Microcontrollers') ->get();
        $kits = ITEM:: where('item_category', '=', 'Kits') ->get();
        $tools = ITEM:: where('item_category', '=', 'Tools') ->get();

        $items = ITEM:: where('borrowed', '=', 'no')->get(); 
        $itemCategories = ItemCategory:: all();
        $pendings = ORDER::where('order_status', '=', 'pending')->get();


        return view('pages.admin.pending')->with(compact('pendings','itemCategories', 'items','pc','monitors','mobileDevs','peripherals','microControllers','kits','tools'));
    }

    public function returned(){
        $forReturns = ORDER::where('order_status', '=', 'returned')->get();

        return view('pages.admin.returned')->with(compact('forReturns'));
    }

    public function pendingItem(Request $request,$id,$serial_number){
        $num = $request->number_of_days;

        // echo $id;
        // exit;
        $user = auth()->user();
        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;

            $affectedRows = Order::where('id','=',$id)->update(['order_status' => 'borrowed', 'release_by' => $firstName .' '. $lastName, 'number_of_days' => $num]);
            $affectedRows1 = Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'yes']);
            Session::flash('success', 'Borrow has been Approved.');
            return redirect('pending');
        }
        
    }

    public function borrowItem(Request $request,$id,$serial_number){
        $remarks = $request->item_remark;
        // echo $serial_number;
        // exit;
        $user = auth()->user();
        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;

            $affectedRows = Order::where('id','=',$id)->update(['order_status' => 'returned', 'return_to' => $firstName .' '. $lastName,'item_remark' => $remarks]);
            $affectedRows1 = Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'no']);
            Session::flash('success', 'Successfuly Return Borrowed Item.');
            return redirect('borrowed');
        }
       
       
    }

    public function removeBorrow($serial_number){
        $affectedRows = Order::where('serial_number','=',$serial_number)->delete();
        $affectedRows1 = Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'no']);
        Session::flash('success', 'Successfuly Remove Borrowed Item.');
        return redirect('pending');
    }

   public function addOrder(Request $request){
    $idNumber = $request->input('idNumber');
    $getUser = User::where('id_number','=', $idNumber)->first();

    if ($getUser) {
        $data1 = $getUser->first_name;
        $data2 = $getUser->last_name;
        
        return response()->json(['data1' => $data1, 'data2' => $data2]);
    }else {
        return response()->json(['error' => 'User not found'], 404);
    }
   }

//    public function insertOrder(Request $request){

//     dd($request);

//     $idNumber = $request->idNumber;
//     $firstName = $request->firstname;
//     $lastName = $request->lastname;
//     $itemCategory = $request->itemCategory;
//     $serialNumber = $request->serialNumber;

   

//    }

}
