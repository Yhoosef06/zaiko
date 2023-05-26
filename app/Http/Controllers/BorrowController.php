<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\OrderItemTemp;
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
        $borrows = OrderItem::where('status', '=', 'borrowed')->get();

        return view('pages.admin.borrowed')->with(compact('borrows'));
    }

    public function pending(){
        $pendings = OrderItemTemp::join('orders', 'order_item_temps.order_id', '=', 'orders.id')
        ->whereNotNull('orders.date_submitted')
        ->whereNull('orders.date_returned')
        ->get();
        $items = ItemCategory::all();
        return view('pages.admin.pending')->with(compact('pendings','items'));
        
    }

    // public function returned(){
    //     $forReturns = ORDER::where('order_status', '=', 'returned')->get();

    //     return view('pages.admin.returned')->with(compact('forReturns'));
    // }

    // public function pendingItem(Request $request,$id,$serial_number){
    //     $num = $request->number_of_days;

    //     // echo $id;
    //     // exit;
    //     $user = auth()->user();
    //     if($user){
    //         $firstName = $user->first_name;
    //         $lastName = $user->last_name;

    //         $affectedRows = Order::where('id','=',$id)->update(['order_status' => 'borrowed', 'release_by' => $firstName .' '. $lastName, 'number_of_days' => $num]);
    //         $affectedRows1 = Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'yes']);
    //         Session::flash('success', 'Borrow has been Approved.');
    //         return redirect('pending');
    //     }
        
    // }

    // public function borrowItem(Request $request,$id,$serial_number){
    //     $remarks = $request->item_remark;
    //     // echo $serial_number;
    //     // exit;
    //     $user = auth()->user();
    //     if($user){
    //         $firstName = $user->first_name;
    //         $lastName = $user->last_name;

    //         $affectedRows = Order::where('id','=',$id)->update(['order_status' => 'returned', 'return_to' => $firstName .' '. $lastName,'item_remark' => $remarks]);
    //         $affectedRows1 = Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'no']);
    //         Session::flash('success', 'Successfuly Return Borrowed Item.');
    //         return redirect('borrowed');
    //     }
       
       
    // }

    // public function removeBorrow($serial_number){
    //     $affectedRows = Order::where('serial_number','=',$serial_number)->delete();
    //     $affectedRows1 = Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'no']);
    //     Session::flash('success', 'Successfuly Remove Borrowed Item.');
    //     return redirect('pending');
    // }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');
    
        $users = User::where('id_number', 'LIKE', $query . '%')->take(10)->get();

        $response = $users->map(function ($user) {
            return [
                'value' => $user->id_number, // User ID
                'label' => $user->id_number, // User display name
                'firstName' => $user->first_name, // User first name
                'lastName' => $user->last_name // User last name
            ];
        });
        return response()->json($response);
    }

    public function searchItem(Request $request)
    {
        $query = $request->input('query');
    
        $items = Item::where('borrowed', 'no')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('serial_number', 'LIKE', $query . '%')
                    ->orWhere('description', 'LIKE', $query . '%');
            })->take(10)->get();
    
        $response = $items->map(function ($item) {
            $category = ItemCategory::find($item->category_id);
            return [
                'value' => $item->serial_number,
                'item_category' => $category ? $category->category_name : null,
                'brand' => $item->brand,
                'model' => $item->model,
                'description' => $item->description
            ];
        });
    
        return response()->json($response);
    }

    public function addOrder(Request $request)
    {

        $id_number = $request->idNumber;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $item_category = $request->item_category;
        $serial_number = $request->serial_number;
        $brand = $request->brand;
        $model = $request->model;
        $item_description = $request->item_description;
        $quantity = $request->quantity;
        $return_date = $request->return_date;

        $user = auth()->user();
        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;

            Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'yes']);
            $order = Order::create([
                'id_number' => $id_number,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'category' => $item_category,
                'serial_number' => $serial_number,
                'brand' => $brand,
                'model' => $model,
                'item_description' => $item_description,
                'quantity' => $quantity,
                'return_date' => $return_date,
                'order_status' => 'borrowed',
                'release_by' => $lastName .', '. $firstName

                
            ]);
            Session::flash('success', 'Successfuly Added Borrowed Item.');
            return redirect('pending');

        }
    }

    // public function addRemark(Request $request)
    // {
    //     $serial_number = $request->serialreturn;
    //     $user = auth()->user();
    //     if($user){
    //         $firstName = $user->first_name;
    //         $lastName = $user->last_name;
    //         Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'no']);
    //         Order::where('serial_number','=',$serial_number)->update([ 'order_status' => 'returned']);
    //         $order = Order::create([
    //             'item_remark' => $request->item_remark,
    //             'return_to' => $lastName .', '. $firstName
    //         ]);
    //          Session::flash('success', 'Successfuly Return.');
    //         return redirect('borrowed');
    //     }
    // }


}
