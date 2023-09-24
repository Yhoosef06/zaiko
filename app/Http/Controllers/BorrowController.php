<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\OrderItemTemp;
use App\Models\Room;
use App\Models\Department;
use App\Models\College;
use App\Models\ItemCategory;
use App\Models\ItemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Rule; 


class BorrowController extends Controller
{

    public function borrowed()
    {   
        $user = auth()->user();
        $user_dept_id = $user->department_id;
        $department = Department::with('college')->find($user_dept_id);
        $college = $department->college;


        $borrows = Order::select('orders.id as transactionId', 'orders.*', 'users.*')
        ->join('users', 'orders.user_id', '=', 'users.id_number')
        ->join('departments', 'users.department_id', '=', 'departments.id')
        ->join('colleges', 'departments.college_id', '=', 'colleges.id')
        ->where('colleges.id', $college->id)
        ->whereNotNull('orders.approval_date')
        ->whereNotNull('orders.approved_by')
        ->groupBy('orders.user_id')
        ->get();

       
        return view('pages.admin.borrowed')->with(compact('borrows'));
    }
    public function overdue()
    {   
        $currentDate = Carbon::now();
        $user = auth()->user();
        $user_dept_id = $user->department_id;
        $department = Department::with('college')->find($user_dept_id);
        $college = $department->college;

     
        $overdueItems = Order::select('orders.id as order_id', 'users.*','brands.brand_name as brand', 'models.model_name as model','order_items.id as order_item_id', 'order_items.*', 'items.*','item_categories.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->join('colleges', 'departments.college_id', '=', 'colleges.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->where('colleges.id', $college->id)
            ->where('order_items.date_returned', '<', $currentDate->toDateString())
            ->where('order_items.status', 'borrowed')
            ->get();

  

        // echo '<pre>';
        // echo print_r($overdueItems);
        // echo '</pre>';
        // exit;
        return view('pages.admin.overdue')->with(compact('overdueItems'));
    }

    public function pending()
    {
        $user = auth()->user();
        $user_dept_id = $user->department_id;
        $department = Department::with('college')->find($user_dept_id);
        $college = $department->college;



       
        $userPendings = Order::select('orders.id as transactionId', 'orders.*', 'users.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->join('colleges', 'departments.college_id', '=', 'colleges.id')
            ->where('colleges.id', $college->id)
            ->whereNotNull('orders.date_submitted')
            ->whereNull('orders.approved_by')
            ->groupBy('orders.id')
            ->get();

     

        return view('pages.admin.pending')->with(compact('userPendings'));
       
    }

    public function returned()
    {
        $forReturns = OrderItem::join('items', 'order_items.item_id', '=', 'items.id')
                            ->join('orders', 'order_items.order_id', '=', 'orders.id')
                            ->where('order_items.status', '=', 'returned')
                            ->get();
        $categories = ItemCategory::all();
        $users = User::all();
        
        return view('pages.admin.returned', compact('forReturns', 'categories', 'users'));
    }

  

    public function removeBorrow($id)
{
    $item = OrderItem::join('items', 'order_items.item_id', '=', 'items.id')
                ->find($id);
    $row = OrderItem::find($id);
    

    if (!$row) {
        return response()->json(['success' => false, 'message' => 'Record not found'], 404);
    }

    $item_id = $item->item_id;
    Item::where('id', $item_id)->update(['borrowed' => 'no']);
    $row->delete();

    return response()->json(['success' => true]);
}

public function orderAdminRemove($id)
{
    $item = OrderItem::join('items', 'order_items.item_id', '=', 'items.id')
                ->find($id);
    $row = OrderItem::find($id);
    

    if (!$row) {
        return response()->json(['success' => false, 'message' => 'Record not found'], 404);
    }

    $item_id = $item->item_id;
    Item::where('id', $item_id)->update(['borrowed' => 'no']);
    $row->delete();

    return response()->json(['success' => true]);
}

    public function searchUser(Request $request)
    {
        $query = $request->input('query');
    
        $users = User::where('account_status', 'approved')->where('role', 'borrower')->where('id_number', 'LIKE', $query . '%')->take(10)->get();

        $response = $users->map(function ($user) {
            return [
                'value' => $user->id_number, 
                'label' => $user->id_number, 
                'firstName' => $user->first_name, 
                'lastName' => $user->last_name 
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
    public function searchItemAdmin(Request $request)
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

    public function searchForSerial(Request $request)
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
                'duration' => $item->duration,
                'brand' => $item->brand,
                'model' => $item->model,
                'description' => $item->description,
                'itemID' => $item->id
            ];
        });
    
        return response()->json($response);
    }

    public function searchItemForAdmin(Request $request)
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

    public function searchItemForUser(Request $request)
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
    public function lostItem(Request $request)
    {
        $orderItemReturn = $request->orderItemReturn;
        $itemIdReturn = $request->itemIdReturn;
        $item_remark = $request->item_remark;
        $quantity_return = $request->quantity_return;
        $categoryName = $request->categoryName;
        $user = auth()->user();

        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $id_number = $user->id_number;

            Item::where('id','=',$itemIdReturn)->update(['borrowed' => 'lost']);
            OrderItem::where('id',$orderItemReturn)->update([ 'status' => 'lost','order_quantity' => $quantity_return , 'remarks' => $item_remark, 'returned_to' => $lastName .', '. $firstName ]);
            ItemLog::create([
                'order_item_id' => $orderItemReturn,
                'item_id' => $itemIdReturn,
                'encoded_by' => $id_number,
                'quantity' => $quantity_return,
                'mode' => 'missing',
                'date' => Carbon::today(),

            ]);
            Session::flash('success', 'A lost item has been successfully logged.');
            return redirect('borrowed');
            
        }
    }

    public function addRemark(Request $request)
    {
        $orderItemReturn = $request->orderItemReturn;
        $itemIdReturn = $request->itemIdReturn;
        $borrowOrderQuantity = $request->borrowOrderQuantity;
        $item_remark = $request->item_remark;
        $quantity_return = $request->quantity_return;
        $categoryName = $request->categoryName;
        $user = auth()->user();

        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $id_number = $user->id_number;
        if($categoryName == 'Tools'){
            if( $quantity_return < $borrowOrderQuantity){
  
                Item::where('id','=',$itemIdReturn)->update(['borrowed' => 'no']);
                OrderItem::where('id',$orderItemReturn)->update([ 'status' => 'returned','order_quantity' => $quantity_return , 'remarks' => $item_remark, 'returned_to' => $lastName .', '. $firstName ]);
                ItemLog::create([
                    'order_item_id' => $orderItemReturn,
                    'item_id' => $itemIdReturn,
                    'encoded_by' => $id_number,
                    'quantity' => $borrowOrderQuantity,
                    'mode' => 'missing',
                    'date' => Carbon::today(),

                ]);
                Session::flash('success', 'Successfuly Return.');
                return redirect('borrowed');
            }else{
                Item::where('id','=',$itemIdReturn)->update(['borrowed' => 'no']);
                OrderItem::where('id',$orderItemReturn)->update([ 'status' => 'returned','order_quantity' => $quantity_return , 'remarks' => $item_remark, 'returned_to' => $lastName .', '. $firstName ]);
                Session::flash('success', 'Successfuly Return.');
                return redirect('borrowed');
            }
        }else{
           
            Item::where('id','=',$itemIdReturn)->update(['borrowed' => 'no']);
            OrderItem::where('id','=',$orderItemReturn)->update([ 'status' => 'returned', 'remarks' =>  $item_remark, 'returned_to' => $lastName .', '. $firstName ]);
    
            Session::flash('success', 'Successfuly Return.');
            return redirect('borrowed');
        }
        
            
        }

     
    }

    public function viewOrderAdmin($id)
    {
        $order = Order::join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->select('orders.id as order_id', 'users.*','order_items.id as order_item_id', 'order_items.*', 'items.*','item_categories.*', 'models.model_name as model', 'brands.brand_name as brand')
            ->where('orders.id', $id)
            ->where('order_items.status', 'pending')
            ->get();
       
    
        return view('pages.admin.viewOrderAdmin')->with(compact('order'));
    }

    public function viewBorrowItem($id){
        $borrows = Order::join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->select('orders.id as order_id', 'users.*','brands.brand_name as brand', 'models.model_name as model','order_items.id as order_item_id', 'order_items.*', 'items.id as item_id_borrow','item_categories.*')
            ->where('orders.id', $id)
            ->where('order_items.status', 'borrowed')
            ->get();


    
        return view('pages.admin.viewBorrowItem')->with(compact('borrows'));

    }
    
    public function viewOrderUser($id)
    {
            $borrowedList = OrderItem::where('status', 'borrowed')->get();
            $missingList = ItemLog::where('mode', 'missing')->get();
            $countTempSerial = OrderItemTemp::join('items', 'order_item_temps.item_id', '=', 'items.id')
                ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
                ->where('order_item_temps.order_id', $id)
                ->where('order_item_temps.temp_serial_number', '')
                ->where('item_categories.category_name', '!=', 'Tools')
                ->distinct()
                ->count();

            $orders = Order::select('orders.id as order_id', 'item_categories.category_name', 'order_item_temps.quantity as orderQty', 'items.quantity as itemQty', 'items.id as item_id', 'users.id_number', 'users.first_name', 'users.last_name', 'items.serial_number', 'brands.brand_name', 'models.model_name', 'items.description', 'order_item_temps.quantity as temp_quantity', 'order_item_temps.*')
                ->join('users', 'orders.user_id', '=', 'users.id_number')
                ->join('order_item_temps', 'order_item_temps.order_id', '=', 'orders.id')
                ->join('items', 'order_item_temps.item_id', '=', 'items.id')
                ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
                ->join('models', 'items.model_id', '=', 'models.id')
                ->join('brands', 'models.brand_id', '=', 'brands.id')
                ->whereNull('orders.approved_by')
                ->where('orders.id', $id)
                ->get();

              

        return view('pages.admin.viewOrderUser')->with(compact('orders', 'borrowedList', 'missingList', 'countTempSerial'));
             
    }

    public function borrowItem(){
        return view('pages.admin.borrowItem');
    }
   
    public function addItem($id){
        $item = Item::select('items.*', 'brands.brand_name as brand', 'models.model_name as model')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->find($id);
       
        return response()->json($item);
    }

    public function pendingBorrow(Request $request)
    {
        $userID = $request->userID;
        $itemId = $request->itemId;
        $serialNumber = $request->serialNumber;

        $dataOrder = Order::where('user_id', $userID)
            ->whereNotNull('date_submitted')
            ->whereNull('date_returned')
            ->get();
        
        if ($dataOrder->isEmpty()) {
            $insertOrder = Order::create([
                'user_id' => $userID,
                'created_by' => 'admin',
                'date_submitted' => Carbon::today()
            ]);
            if ($insertOrder) {
                $orderId = $insertOrder->id;
                Item::where('serial_number', '=', $serialNumber)->update(['borrowed' => 'yes']);
                $data = OrderItem::create([
                    'user_id' => $userID,
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'order_quantity' => 1,
                    'status' => 'pending',
                    'order_serial_number' => $serialNumber
                ]);
            
               
            }
        }else{
            $order = $dataOrder->first();
            $orderId = $order->id;
            Item::where('serial_number', '=', $serialNumber)->update(['borrowed' => 'yes']);
                $data = OrderItem::create([
                    'user_id' => $userID,
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'order_quantity' => 1,
                    'status' => 'pending',
                    'order_serial_number' => $serialNumber
                ]);

        }
        return response()->json(['success' => true]);
   
    }

    public function userPendingBorrow(Request $request)
    {
        $userID = $request->userID;
        $itemId = $request->itemId;
        $serialNumber = $request->serialNumber;


        $dataOrder = Order::where('user_id', $userID)
            ->whereNotNull('date_submitted')
            ->whereNull('date_returned')
            ->get();
        
        if ($dataOrder->isEmpty()) {
            $insertOrder = Order::create([
                'user_id' => $userID,
                'created_by' => 'user',
                'date_submitted' => Carbon::today()
            ]);
            if ($insertOrder) {
                $orderId = $insertOrder->id;
                OrderItemTemp::create([
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => 1,
                    'temp_serial_number' => $serialNumber
                ]);
            
               
            }
        }else{
            $orderId = $dataOrder->first()->id;
                OrderItemTemp::create([
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => 1,
                    'temp_serial_number' => $serialNumber   
                ]);

        }
        return response()->json(['success' => true]);
   
    }


   
    public function adminAddedOrder(Request $request)
    {
        $userId = $request->userId;
        $itemId = $request->itemId;
        $brand = $request->brand;
        $model = $request->model;
        $description = $request->description;
        $serial = $request->serial;
        $orderQuantity = $request->quantity;
    
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
                OrderItem::create([
                    'order_id' => $orderId,
                    'user_id' => $userId,
                    'item_id' => $itemId,
                    'order_quantity' => $orderQuantity,
                    'status' => 'pending',
                    'order_serial_number' => $serial
                ]);
            }
        } else {
            $orderId = $dataOrder->first()->id;
            OrderItem::create([
                'order_id' => $orderId,
                'user_id' => $userId,
                'item_id' => $itemId,
                'order_quantity' => $orderQuantity,
                'status' => 'pending',
                'order_serial_number' => $serial
            ]);
        }
        return response()->json(['success' => true]);
       
    }
    public function borrowItemAdmin($id){
        $order = Order::join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->select('orders.id as order_id','brands.*', 'models.*', 'users.*','order_items.order_quantity as order_quantity','order_items.id as order_item_id', 'order_items.user_id as user_id', 'items.*','item_categories.*')
            ->where('users.id_number', $id)
            ->where('order_items.status', 'pending')
            ->get();
    
        return view('pages.admin.borrowItemAdmin')->with(compact('order'));
    }


    public function checkUserId($id)
    { 
        $checkUser = Order::where('user_id', $id)
        ->whereNotNull('date_submitted')
        ->whereNull('date_returned')
        ->get();

        if ($checkUser->count() > 0) {
        return response()->json(['exists' => true]);
        } else {
        return response()->json(['exists' => false]);
        }
    }
    


    public function submitAdminBorrow(Request $request)
    {
        
          echo '<pre>';
            echo print_r($request->all());
            echo '</pre>';
            exit;
        // $orderIds = $request->order_id;
        // $quantity= $request->quantity;
       
        // $user = auth()->user();
         
    
        // if($user){
        //     $firstName = $user->first_name;
        //     $lastName = $user->last_name;
        //     if (!empty($orderIds)) {
        //         if (!empty($date_return)) {
        //             Order::whereIn('id', $orderIds)->update([
        //                 'date_returned' => $Carbon::today(),
        //                 'approval_date' => Carbon::today(),
        //                 'approved_by' => $firstName . ' ' . $lastName
        //             ]);
            
        //             foreach ($orderIds as $index => $orderId) {
        //                 $orderItem = OrderItem::where('order_id', $orderId)
        //                     ->where('status', 'pending')
        //                     ->first();
            
        //                 if ($orderItem) {
        //                     $orderItem->order_quantity = $quantity[$index];
        //                     $orderItem->status = 'borrowed';
        //                     $orderItem->released_by = $firstName . ' ' . $lastName;
        //                     $orderItem->date_returned = $date_return;
        //                     $orderItem->save();
        //                 }
        //             }
            
        //             return response()->json(['success' => 'Successfully added borrowed item.']);
        //         } else {
        //             return response()->json(['error' => 'Error: Date not provided.']);
        //         }
        //     } else {
        //         return response()->json(['error' => 'Error: No order selected.']);
        //     }
        // }
    }

    public function submitUserBorrow(Request $request)
    {
        $orderId = $request->input('order_id');
        $student_id_added_user = $request->input('student_id_added_user');
        $serialNumbers = $request->input('user_serial_number');
        $quantity = $request->input('quantity');
        $itemId = $request->input('itemId');
        $duration = $request->input('duration');
        $user = auth()->user();
        $uniqueSerialNumbers = [];
        $currentDate = Carbon::now();

        
    
        $validator = Validator::make($request->all(), [
            'user_serial_number.*' => [
                'required',
                function ($attribute, $value, $fail) use (&$uniqueSerialNumbers, $itemId) {
                  
                    if ($value !== 'N/A') {
                        
                        if (in_array($value, $uniqueSerialNumbers)) {
                            $fail("$attribute is not unique.");
                        } else {
                           
                            $uniqueSerialNumbers[] = $value;
                        }
                    }
                },
            ],
           
        ]);
    
        if ($validator->fails()) {
            return response()->json(['duplicate' => $validator->errors()->all()]);
        }
    
        
        $existingItems = Item::whereIn('serial_number', $serialNumbers)->where('borrowed', 'no')->get();
        
    
        foreach ($serialNumbers as $serialNumber) {
            if (!$existingItems->contains('serial_number', $serialNumber)) {
                return response()->json(['error' => "Serial number '$serialNumber' does not exist in the item table."]);
            }
        }

        if ($user) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
        
            Order::whereIn('id', $orderId)->update([
                'approval_date' => Carbon::today(),
                'approved_by' => $firstName . ' ' . $lastName
            ]);
        
            foreach ($itemId as $index => $id) {
                $item = Item::join('item_categories', 'items.category_id', '=', 'item_categories.id')
                    ->where('items.id', $id)
                    ->first();
                if (isset($itemId[$index]) && isset($quantity[$index]) && isset($serialNumbers[$index])) {
                    $order = $orderId[$index];
                    $durationDay = $duration[$index];

                    
                    $dateReturn = $currentDate->copy()->addDays($durationDay);

                    if( $dateReturn->dayOfWeek === Carbon::SUNDAY)
                    {
                        $dateReturn->addDay();
                    }
                   
            
                    if ($item->category_name === 'Tools') {
                        OrderItem::create([
                            'order_id' => $order,
                            'user_id' => $student_id_added_user,
                            'item_id' => $itemId[$index],
                            'order_quantity' => $quantity[$index],
                            'status' => 'borrowed',
                            'order_serial_number' => $serialNumbers[$index],
                            'date_returned' =>  $dateReturn->format('Y-m-d'),
                            'released_by' => $lastName . ' ' . $firstName
                        ]);
                    } else {
                        OrderItem::create([
                            'order_id' => $order,
                            'user_id' => $student_id_added_user,
                            'item_id' => $itemId[$index],
                            'order_quantity' => $quantity[$index],
                            'status' => 'borrowed',
                            'order_serial_number' => $serialNumbers[$index],
                            'date_returned' =>  $dateReturn->format('Y-m-d'),
                            'released_by' => $lastName . ' ' . $firstName
                        ]);
                        Item::whereIn('id', $itemId)->update(['borrowed' => 'yes']);
                    }
                }
            }
        }
        

        return response()->json(['success' => 'Serial numbers are valid.']);
            
    }
        
        
       

    
    

   
    
    public function adminNewOrder(Request $request){
        $userId = $request->userId;
        $itemId = $request->itemId;
        $orderId = $request->orderId;
        $brand = $request->brand;
        $model = $request->model;
        $description = $request->description;
        $serial = $request->serial;
        $quantity = $request->quantity;

        $user = auth()->user();

        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            Item::where('serial_number', $serial)->update(['borrowed' => 'yes']);
            OrderItem::create([
                'order_id' => $orderId,
                'user_id' => $userId,
                'item_id' => $itemId,
                'quantity' => $quantity,
                'status' => 'pending',
                'released_by' => $firstName .' '. $lastName,
                'order_serial_number' => $serial
            ]);
            return response()->json(['success' => 'Successfully added borrowed item.']);
        }
    }

    public function userNewOrder(Request $request){
        $userId = $request->userId;
        $itemId = $request->itemId;
        $brand = $request->brand;
        $model = $request->model;
        $description = $request->description;
        $serial = $request->serial;
        $orderQuantity = $request->quantity;



        $dataOrder = Order::where('user_id', $userId)
            ->whereNotNull('date_submitted')
            ->whereNull('date_returned')
            ->get();

            if ($dataOrder->isEmpty()) {
                $insertOrder = Order::create([
                    'user_id' => $userId,
                    'created_by' => 'user',
                    'date_submitted' => Carbon::today()
                ]);
        
                if ($insertOrder) {
                    $orderId = $insertOrder->id;
                    OrderItemTemp::create([
                        'order_id' => $orderId,
                        'item_id' => $itemId,
                        'quantity' => $orderQuantity,
                        'temp_serial_number' => 'N/A'
                    ]);
                }
            } else {
                $orderId = $dataOrder->first()->id;
                OrderItemTemp::create([
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => $orderQuantity,
                    'temp_serial_number' => 'N/A'
                ]);
            }
            return response()->json(['success' => true]);
 
    }


    public function submitAdminOrder(Request $request)
    {
        $rowData = $request->input('data');
        $date_return = $request->input('date_returned');
        $user = auth()->user();
    
        if ($user) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
    
            if (!empty($date_return)) {
                $orderIds = [];
    
                foreach ($rowData as $row) {
                    $orderId = $row['orderId'];
                    $orderIds[] = $orderId;
                }
    
                Order::whereIn('id', $orderIds)->update([
                    'date_returned' => $date_return,
                    'approval_date' => Carbon::today(),
                    'approved_by' => $firstName . ' ' . $lastName
                ]);
    
                OrderItem::whereIn('order_id', $orderIds)
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'borrowed',
                        'released_by' => $firstName . ' ' . $lastName,
                        'date_returned' => $date_return
                    ]);
    
                return response()->json(['success' => 'Successfully added borrowed item.']);
            } else {
                return response()->json(['error' => 'Error: Date not provided.']);
            }
        }
    }

    public function updateQuantity(Request $request)
{
    $quantity = $request->input('quantity');
    $itemId = $request->input('itemId');
    $orderItemId = $request->input('orderItemId');

    $orderItem = OrderItem::find($orderItemId);
    $available = Item::find($itemId);

    $availableQuantity = $available->available_quantity;
    $currentOrderQuantity = $orderItem->order_quantity;

    $availableQuantity += $currentOrderQuantity;
    $availableQuantity -= $quantity;

    Item::where('id', $itemId)->update(['available_quantity' => $availableQuantity]);
    OrderItem::where('id', $orderItemId)->update(['order_quantity' => $quantity]);
}
    


}
