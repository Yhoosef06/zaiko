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
   


    public function borrowed()
    {   
        // $category = Item::join
        $borrows = OrderItem::join('items', 'order_items.item_id', '=', 'items.id')->join('users', 'order_items.user_id', '=', 'users.id_number')->where('order_items.status', '=', 'borrowed')->get();
        $categories = ItemCategory::all();

        return view('pages.admin.borrowed')->with(compact('borrows','categories'));
    }

    public function pending()
    {
        $pendings = OrderItemTemp::join('orders', 'order_item_temps.order_id', '=', 'orders.id')->get();
        $users = User::all();
        // return view('pages.admin.pending')->with(compact('pendings','items')); 
        // $pendings = Order::with('user')->whereNotNull('date_submitted')->whereNull('date_returned')->get();
        // dd($pendings);

        // echo '<pre>';
        // print_r($pendings);
        // echo '<pre>';
        // exit;

        return view('pages.admin.pending')->with(compact('pendings','users'));
       
    }

    public function returned(){
        $forReturns =  $borrows = OrderItem::join('items', 'order_items.item_id', '=', 'items.id')->join('users', 'order_items.user_id', '=', 'users.id_number')->where('order_items.status', '=', 'returned')->get();
        $categories = ItemCategory::all();
        return view('pages.admin.returned')->with(compact('forReturns','categories'));
    }

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
                'value' => $item->serial_number . ' - ' . $item->description,
                'item_category' => $category ? $category->category_name : null,
                'id' => $item->id,
                'serialNumber' => $item->serial_number,
                'brand' => $item->brand,
                'model' => $item->model,
                'description' => $item->description,
                'itemID' => $item->id
            ];
        });
    
        return response()->json($response);
    }

    public function addOrder(Request $request)
    {

        $id_number = $request->idNumber;
        $item_id = $request->item_id;
        $serial_number = $request->serial_number;
        $quantity = $request->quantity;
        $return_date = $request->date_returned;
        $user = auth()->user();
        // dd($user);
        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            // echo $lastName;
            // exit;

            Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'yes']);
            $order = OrderItem::create([
                'user_id' => $id_number,
                'item_id' => $item_id,
                'quantity' => $quantity,
                'status' => 'borrowed',
                'order_serial_number' => $serial_number,
                'date_returned' => $return_date,
                'released_by' => $lastName .' '. $firstName

            ]);
            Session::flash('success', 'Successfuly Added Borrowed Item.');
            return redirect('pending');

        }
    }

    public function addRemark(Request $request)
    {
        $status = $request->status;
        $serial_number = $request->serialreturn;
        $remark = $request->item_remark;
        echo 
        $user = auth()->user();
        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            Item::where('serial_number','=',$serial_number)->update(['borrowed' => 'no', 'status' => $status]);
            OrderItem::where('order_serial_number','=',$serial_number)->update([ 'status' => 'returned', 'remarks' =>  $remark, 'returned_to' => $lastName .', '. $firstName ]);
            // $order = OrderItem::create([
            //     'item_remark' => $request->item_remark,
            //     'return_to' => $lastName .', '. $firstName
            // ]);
             Session::flash('success', 'Successfuly Return.');
            return redirect('borrowed');
        }
    }

    // public function viewOrder($id)
    // {
    //     $order_temp = OrderItemTemp::find($id);
    //     $order = OrderItemTemp::join('orders', 'order_item_temps.order_id', '=', 'orders.id')
    //         ->join('users', 'orders.user_id', '=', 'users.id_number')
    //         ->join('items', 'order_item_temps.item_id', '=', 'items.id')
    //         ->where('order_item_temps.id', $id)
    //         ->first();
    
    //     echo '<pre>';
    //     print_r($order_temp);
    //     echo '</pre>';
    //     exit;
    
    //     return view('pages.admin.viewOrder')->with(compact('order_temp'));
    // }

    public function borrowItem(){
        return view('pages.admin.borrowItem');
    }

    public function addItem($id){
        $item = Item::find($id);

        return response()->json($item);
    }
    public function pendingBorrow(Request $request)
    {
        $userID = $request->userID;
        $itemId = $request->itemId;
        $serialNumber = $request->serialNumber;
    
        Item::where('serial_number', '=', $serialNumber)->update(['borrowed' => 'yes']);
    
        $data = OrderItem::create([
            'user_id' => $userID,
            'item_id' => $itemId,
            'quantity' => 1,
            'status' => 'pending',
            'order_serial_number' => $serialNumber
        ]);
    
        $response = OrderItem::where('order_items.status', 'pending')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->where('order_items.user_id', $userID)
            ->get();
    
        return response()->json($response);
    }
 


}
