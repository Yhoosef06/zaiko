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
use Carbon\Carbon;


class BorrowController extends Controller
{

    public function borrowed()
    {   
        $borrows = OrderItem::join('items', 'order_items.item_id', '=', 'items.id')->join('users', 'order_items.user_id', '=', 'users.id_number')->where('order_items.status', '=', 'borrowed')->get();
        $categories = ItemCategory::all();

        return view('pages.admin.borrowed')->with(compact('borrows','categories'));
    }

    public function pending()
    {
        $adminPendings = OrderItem::join('users', 'order_items.user_id', '=', 'users.id_number')
        ->join('items', 'order_items.item_id', '=', 'items.id')
        ->where('order_items.status', '=', 'pending')
        ->groupBy('order_items.user_id')
        ->get();

        $userPendings = Order::join('users', 'orders.user_id', '=', 'users.id_number')
        ->join('order_item_temps', 'order_item_temps.order_id', '=', 'orders.id')
        ->join('items', 'order_item_temps.item_id', '=', 'items.id')
        ->whereNotNull('orders.date_submitted')
        ->whereNull('orders.date_returned')
        ->groupBy('orders.user_id')
        ->get();
      

        return view('pages.admin.pending')->with(compact('adminPendings','userPendings'));
       
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

    public function removeBorrow($order_item_id, $serial_number, $description)
    {
        if (empty($serial_number) || $serial_number == 'N/A') {
            Item::where('description', $description)->update(['borrowed' => 'no']);
            OrderItem::where('id', '=', $order_item_id)->delete();
            Session::flash('success', 'Successfully removed the borrowed item.');
            return redirect('pending');
        }

        // Continue with the removal logic if the serial number is valid
        $affectedRows = OrderItem::where('id', '=', $order_item_id)->delete();
        $affectedRows1 = Item::where('serial_number', '=', $serial_number)->update(['borrowed' => 'no']);
        Session::flash('success', 'Successfully removed the borrowed item.');
        return redirect('view-order');
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');
    
        $users = User::where('account_status', 'approved')->where('id_number', 'LIKE', $query . '%')->take(10)->get();

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

    public function viewOrderAdmin($id)
    {
      

        $order = OrderItem::select('order_items.id as order_item_id', 'items.id as item_id', 'users.id_number', 'users.first_name', 'users.last_name', 'items.brand', 'items.model', 'items.description', 'items.serial_number', 'order_items.quantity')
                ->join('users', 'order_items.user_id', '=', 'users.id_number')
                ->join('items', 'order_items.item_id', '=', 'items.id')
                ->where('order_items.user_id', $id)
                ->where('order_items.status', 'pending')
                ->get();
 
       
    
        return view('pages.admin.viewOrderAdmin')->with(compact('order'));
    }

    public function viewOrderUser($id)
    {
      

        $orders = Order::select('item_categories.category_name','items.id as item_id', 'users.id_number', 'users.first_name', 'users.last_name', 'items.brand', 'items.model', 'items.description', 'order_item_temps.quantity')
                    ->join('users', 'orders.user_id', '=', 'users.id_number')
                    ->join('order_item_temps', 'order_item_temps.order_id', '=', 'orders.id')
                    ->join('items', 'order_item_temps.item_id', '=', 'items.id')
                    ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
                    ->get();
 
     
    
        return view('pages.admin.viewOrderUser')->with(compact('orders'));
    }

    public function borrowItem(){
        return view('pages.admin.borrowItem');
    }

    public function addItem($id){
        $item = Item::find($id);

        return response()->json($item);
    }
    public function pendingBorrow(Request $request)
    {
        $userId = $request->input('userID');
        $itemId = $request->input('itemId');
        $serialNumber = $request->input('serialNumber');
    
        $dataOrder = Order::where('user_id', $userId)
            ->whereNotNull('date_submitted')
            ->whereNull('date_returned')
            ->get();
    
        if ($dataOrder->isEmpty()) {
            $insertOrder = Order::create([
                'user_id' => $userId,
                'created_by' => 'admin',
                'date_submitted' => Carbon::today()
            ]);
    
            if ($insertOrder) {
                $orderId = $insertOrder->id;
                Item::where('serial_number', $serialNumber)->update(['borrowed' => 'yes']);
                $data = OrderItem::create([
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => 1,
                    'status' => 'pending',
                    'order_serial_number' => $serialNumber
                ]);
    
                $response = OrderItem::where('order_items.status', 'pending')
                    ->join('items', 'order_items.item_id', '=', 'items.id')
                    ->where('order_items.user_id', $userId)
                    ->get();
    
                return response()->json($response);
            }
        } else {
            $order = $dataOrder->first();
            Item::where('serial_number', $serialNumber)->update(['borrowed' => 'yes']);
            $orderId = $order->id;
    
            $data = OrderItem::create([
                'order_id' => $orderId,
                'item_id' => $itemId,
                'quantity' => 1,
                'status' => 'pending',
                'order_serial_number' => $serialNumber
            ]);
    
            $response = OrderItem::where('order_items.status', 'pending')
                ->join('items', 'order_items.item_id', '=', 'items.id')
                ->where('order_items.user_id', $userId)
                ->get();
    
            return response()->json($response);
        }
    }
   
    public function adminAddedOrder(Request $request)
    {
        $userId = $request->userId;
        $itemId = $request->itemId;
        $brand = $request->brand;
        $model = $request->model;
        $description = $request->description;
        $serial = $request->serial;
        $quantity = $request->quantity;
        

        $dataOrder = Order::where('user_id', $userId)
            ->whereNotNull('date_submitted')
            ->whereNull('date_returned')
            ->get();

        if ($dataOrder->isEmpty()) {
            $insertOrder = Order::create([
                'user_id' => $userId,
                'created_by' => 'admin',
                'date_submitted' => Carbon::today()
            ]);

            if ($insertOrder) {
                $orderId = $insertOrder->id;
                $data = OrderItem::create([
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                    'status' => 'pending',
                    'order_serial_number' => $serial
                ]);

                $responseData = [
                    'userId' => $userId,
                    'brand' => $brand,
                    'model' => $model,
                    'description' => $description,
                    'serial' => $serial,
                    'quantity' => $quantity
                ];

                return response()->json($responseData);
            }
        } else {
            $orderId = $dataOrder->first()->id;
            $data = OrderItem::create([
                'order_id' => $orderId,
                'item_id' => $itemId,
                'quantity' => $quantity,
                'status' => 'pending',
                'order_serial_number' => $serial
            ]);

            $responseData = [
                'userId' => $userId,
                'brand' => $brand,
                'model' => $model,
                'description' => $description,
                'serial' => $serial,
                'quantity' => $quantity
            ];

            return response()->json($responseData);
        }
    }


    public function checkUserId($id)
    { 
        $checkUser = Order::where('user_id', $id)
        ->whereNotNull('date_submitted')
        ->whereNull('date_returned')
        ->get();

        if ($checkUser->count() > 0) {
        // User ID already exists
        return response()->json(['exists' => true]);
        } else {
        // User ID does not exist
        return response()->json(['exists' => false]);
        }
    }
    


 


}
