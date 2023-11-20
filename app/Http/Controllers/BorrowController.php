<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use App\Models\OrderItem;
use App\Models\OrderItemTemp;
use App\Models\Room;
use App\Models\Department;
use App\Models\College;
use App\Models\ItemCategory;
use App\Models\ItemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Rule;


class BorrowController extends Controller
{

    public function borrowed()
    {
        

        $department = Auth::user()->departments->first();

        $borrows = Order::select('orders.id as transactionId', 'orders.*', 'users.*', 'items.*', 'rooms.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_item_temps', 'orders.id', '=', 'order_item_temps.order_id')
            ->join('items', 'order_item_temps.item_id', '=', 'items.id')
            ->join('rooms', 'items.location', '=', 'rooms.id')
            ->where('rooms.department_id', $department->id)
            ->WhereNull('orders.order_status')
            ->whereNotNull('orders.approval_date')
            ->whereNotNull('orders.approved_by')
            ->groupBy('orders.id')
            ->get();
            
       


        return view('pages.admin.borrowed')->with(compact('borrows'));
    }
    public function overdue()
    {
        $currentDate = Carbon::now();
        $department = Auth::user()->departments->first();

        $overdueItems = Order::select('orders.id as order_id', 'users.*', 'brands.brand_name as brand', 'models.model_name as model', 'order_items.id as order_item_id', 'order_items.*', 'items.*', 'item_categories.*')
        ->join('users', 'orders.user_id', '=', 'users.id_number')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('items', 'order_items.item_id', '=', 'items.id')
        ->join('rooms', 'items.location', '=', 'rooms.id')
        ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
        ->join('models', 'items.model_id', '=', 'models.id')
        ->join('brands', 'models.brand_id', '=', 'brands.id')
        ->where('order_items.status', 'borrowed')
        ->where('order_items.date_returned', '<', $currentDate->toDateString())
        ->where('rooms.department_id', $department->id)
        ->get();
        


        foreach ($overdueItems as $item) {
            $dateReturned = Carbon::parse($item->date_returned); 
            $daysOverdue = $dateReturned->diffInDays($currentDate);
            $item->days_overdue = $daysOverdue;
        }
        
    // echo '<pre>';
    // print_r($overdueItems);
    // echo '</pre>';
    // exit;

        return view('pages.admin.overdue')->with(compact('overdueItems'));
    }
    

    public function pending()
    {
        $department = Auth::user()->departments->first();
     
        $userPendings = Order::select('orders.id as transactionId', 'orders.*', 'users.*', 'items.*', 'rooms.*')
        ->join('users', 'orders.user_id', '=', 'users.id_number')
        ->join('order_item_temps', 'orders.id', '=', 'order_item_temps.order_id')
        ->join('items', 'order_item_temps.item_id', '=', 'items.id')
        ->join('rooms', 'items.location', '=', 'rooms.id')
        ->where('rooms.department_id', $department->id)
        ->whereNotNull('orders.date_submitted')
        ->whereNull('orders.approval_date')
        ->whereNull('orders.approved_by')
        ->groupBy('orders.id')
        ->get();

      

        // echo '<pre>';
        // print_r($userPendings);
        // echo '</pre>';
        // exit;

        return view('pages.admin.pending')->with(compact('userPendings'));
        
    }

    public function returned()
    {
        $department = Auth::user()->departments->first();
        $forReturns = OrderItem::select('order_items.date_returned as returndate', 'items.*', 'users.*', 'brands.*', 'models.*', 'item_categories.*', 'orders.*', 'order_items.*')
            ->join('users', 'order_items.user_id', '=', 'users.id_number')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('rooms', 'items.location', '=', 'rooms.id')
            ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('rooms.department_id', $department->id)
            ->where('order_items.status','returned')
            ->get();
     

        return view('pages.admin.returned', compact('forReturns'));
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


    public function completeTransaction($id) {
        $orderItemCount = OrderItem::where('order_id', $id)->where('status', 'borrowed')->count();
    
        if ($orderItemCount > 0) {
            return response()->json(['error' => 'Order cannot be completed as there are borrowed items associated with it']);
        } else {
            Order::where('id', $id)->update(['order_status' => 'completed']);
            return response()->json(['success' => true]);
        }
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

    public function orderUserRemove($id)
    {
        $item = OrderItemTemp::where('id',$id)->first();

        
            $item->delete();
            return response()->json(['success' => true]);
        

    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('account_status', 'approved')->where('id_number', 'LIKE', $query . '%')->take(10)->get();

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
        $department = Auth::user()->departments->first();
        $query = $request->input('query');

        $items = Item::select('items.id as itemID', 'items.*')
        ->join('rooms', 'items.location', '=', 'rooms.id')
        ->where('rooms.department_id', $department->id)
        ->where('borrowed', 'no')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('serial_number', 'LIKE', $query . '%')
                    ->orWhere('description', 'LIKE', $query . '%');
            })->take(10)->get();


        $response = $items->map(function ($item) {
            $category = ItemCategory::find($item->category_id);
            return [
                'value' => $item->serial_number . ' - ' . $item->description,
                'item_category' => $category ? $category->category_name : null,
                'serialNumber' => $item->serial_number,
                'duration' => $item->duration,
                'brand' => $item->brand,
                'model' => $item->model,
                'description' => $item->description,
                'itemID' => $item->itemID
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
        $department = Auth::user()->departments->first();
    

        $query = $request->input('query');

        $items = Item::select('items.id as itemID', 'items.*')->join('rooms', 'items.location', '=', 'rooms.id')
        ->where('rooms.department_id', $department->id)
        ->where('borrowed', 'no')
        ->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('serial_number', 'LIKE', $query . '%')
                ->orWhere('description', 'LIKE', $query . '%');
        })
        
        ->take(10)
        ->get();
    


        $response = $items->map(function ($item) {
            $category = ItemCategory::find($item->category_id);
            return [
                'value' => $item->serial_number . ' - ' . $item->description,
                'item_category' => $category ? $category->category_name : null,
                'id' => $item->itemID,
                'serialNumber' => $item->serial_number,
                'brand' => $item->brand,
                'model' => $item->model,
                'description' => $item->description,
                'duration' => $item->duration,
                'itemID' => $item->itemID
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

        if ($user) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $id_number = $user->id_number;

            Item::where('id', '=', $itemIdReturn)->update(['borrowed' => 'lost']);
            OrderItem::where('id', $orderItemReturn)->update(['status' => 'lost', 'order_quantity' => $quantity_return, 'remarks' => $item_remark, 'returned_to' => $lastName . ', ' . $firstName]);
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
    public function lostOverdueItem(Request $request)
    {
        $orderItemReturn = $request->orderItemReturn;
        $itemIdReturn = $request->itemIdReturn;
        $item_remark = $request->item_remark;
        $quantity_return = $request->quantity_return;
        $categoryName = $request->categoryName;
        $user = auth()->user();

        if ($user) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $id_number = $user->id_number;

            Item::where('id', '=', $itemIdReturn)->update(['borrowed' => 'lost']);
            OrderItem::where('id', $orderItemReturn)->update(['status' => 'lost', 'order_quantity' => $quantity_return, 'remarks' => $item_remark, 'returned_to' => $lastName . ', ' . $firstName]);
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
    public function returnOverdueItem(Request $request)
    {
        $orderItemReturn = $request->orderItemReturn;
        $itemIdReturn = $request->itemIdReturn;
        $borrowOrderQuantity = $request->borrowOrderQuantity;
        $item_remark = $request->item_remark;
        $quantity_return = $request->quantity_return;
        $categoryName = $request->categoryName;
        $user = auth()->user();

        if ($user) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $id_number = $user->id_number;
            if ($categoryName == 'Tools') {
                if ($quantity_return < $borrowOrderQuantity) {

                    Item::where('id', '=', $itemIdReturn)->update(['borrowed' => 'no']);
                    OrderItem::where('id', $orderItemReturn)->update(['status' => 'returned', 'order_quantity' => $quantity_return, 'remarks' => $item_remark, 'returned_to' => $lastName . ', ' . $firstName]);
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
                } else {
                    Item::where('id', '=', $itemIdReturn)->update(['borrowed' => 'no']);
                    OrderItem::where('id', $orderItemReturn)->update(['status' => 'returned', 'order_quantity' => $quantity_return, 'remarks' => $item_remark, 'returned_to' => $lastName . ', ' . $firstName]);
                    Session::flash('success', 'Successfuly Return.');
                    return redirect('borrowed');
                }
            } else {

                Item::where('id', '=', $itemIdReturn)->update(['borrowed' => 'no']);
                OrderItem::where('id', '=', $orderItemReturn)->update(['status' => 'returned', 'remarks' =>  $item_remark, 'returned_to' => $lastName . ', ' . $firstName]);

                Session::flash('success', 'Successfuly Return.');
                return redirect('borrowed');
            }
        }
    }

    public function addRemark(Request $request)
    {
        $orderItemReturn = $request->orderItemReturn;
        $orderTransaId = $request->orderTransacId;
        $itemIdReturn = $request->itemIdReturn;
        $borrowOrderQuantity = $request->borrowOrderQuantity;
        $item_remark = $request->item_remark;
        $quantity_return = $request->quantity_return;
        $categoryName = $request->categoryName;
        $user = auth()->user();
        // dd($orderItemReturn);

        if ($user) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $id_number = $user->id_number;
            if ($categoryName == 'Tools') {
                if ($quantity_return < $borrowOrderQuantity) {

                    Item::where('id', '=', $itemIdReturn)->update(['borrowed' => 'no']);
                    OrderItem::where('id', $orderItemReturn)->update(['status' => 'returned', 'order_quantity' => $quantity_return, 'remarks' => $item_remark, 'returned_to' => $lastName . ', ' . $firstName]);
                    ItemLog::create([
                        'order_item_id' => $orderItemReturn,
                        'item_id' => $itemIdReturn,
                        'encoded_by' => $id_number,
                        'quantity' => $borrowOrderQuantity,
                        'mode' => 'missing',
                        'date' => Carbon::today(),

                    ]);
                    Session::flash('success', 'Successfuly Return.');
                    return redirect()->route('view-borrow-item', ['id' => $orderTransaId]);
                } else {
                    Item::where('id', '=', $itemIdReturn)->update(['borrowed' => 'no']);
                    OrderItem::where('id', $orderItemReturn)->update(['status' => 'returned', 'order_quantity' => $quantity_return, 'remarks' => $item_remark, 'returned_to' => $lastName . ', ' . $firstName]);
                    Session::flash('success', 'Successfuly Return.');
                   
                    return redirect()->route('view-borrow-item', ['id' => $orderTransaId]);
                }
            } else {

                Item::where('id', '=', $itemIdReturn)->update(['borrowed' => 'no']);
                OrderItem::where('id', '=', $orderItemReturn)->update(['status' => 'returned', 'remarks' =>  $item_remark, 'returned_to' => $lastName . ', ' . $firstName]);

                Session::flash('success', 'Successfuly Return.');
                return redirect()->route('view-borrow-item', ['id' => $orderTransaId]);
            }
        }
    }

    public function viewOrderAdmin($id)
    {
        $count = Order::join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->select('orders.id as order_id', 'users.*', 'order_items.id as order_item_id', 'order_items.*', 'items.*', 'item_categories.*', 'models.model_name as model', 'brands.brand_name as brand')
            ->where('orders.id', $id)
            ->where('order_items.status', 'pending')
            ->count();
        if($count == 0){
            Order::find($id)->delete();
            return redirect('pending');
        }else{
            $order = Order::join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->select('orders.id as order_id', 'users.*', 'order_items.id as order_item_id', 'order_items.*', 'items.*', 'item_categories.*', 'models.model_name as model', 'brands.brand_name as brand')
            ->where('orders.id', $id)
            ->where('order_items.status', 'pending')
            ->get();


            return view('pages.admin.viewOrderAdmin')->with(compact('order'));
        }

        
    }

    public function viewBorrowItem($id)
    {
        $count = Order::join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->select('orders.id as order_id', 'users.*', 'brands.brand_name as brand', 'models.model_name as model', 'order_items.id as order_item_id', 'order_items.*', 'items.id as item_id_borrow', 'item_categories.*', 'items.description as description')
            ->where('orders.id', $id)
            ->where('order_items.status', 'borrowed')
            ->count();

            if( $count === 0){
            Order::where('id', $id)->update(['order_status' => 'Completed', 'date_returned' => Carbon::today()]);
            return redirect('borrowed');
            }else{
            
                $borrows = Order::join('users', 'orders.user_id', '=', 'users.id_number')
                    ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                    ->join('items', 'order_items.item_id', '=', 'items.id')
                    ->join('item_categories', 'items.category_id', 'item_categories.id')
                    ->join('models', 'items.model_id', '=', 'models.id')
                    ->join('brands', 'models.brand_id', '=', 'brands.id')
                    ->select('orders.id as order_id', 'users.*', 'brands.brand_name as brand', 'models.model_name as model', 'order_items.id as order_item_id', 'order_items.*', 'items.id as item_id_borrow', 'item_categories.*', 'items.description as description')
                    ->where('orders.id', $id)
                    ->where('order_items.status', 'borrowed')
                    ->get();
                return view('pages.admin.viewBorrowItem')->with(compact('borrows'));
            }


       
    }

    public function viewOrderUser($id)
    {
        $borrowedList= OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();
     

        $orders = Order::select('orders.id as order_id', 'item_categories.category_name', 'order_item_temps.quantity as orderQty', 'items.quantity as itemQty', 'items.id as item_id', 'users.id_number', 'users.first_name', 'users.last_name', 'items.serial_number', 'brands.brand_name', 'models.model_name', 'items.description', 'order_item_temps.id as orderItempId','order_item_temps.quantity as temp_quantity', 'order_item_temps.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_item_temps', 'order_item_temps.order_id', '=', 'orders.id')
            ->join('items', 'order_item_temps.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->whereNull('orders.approved_by')
            ->where('orders.id', $id)
            ->get();
   
        // dd($borrowedList);

        return view('pages.admin.viewOrderUser')->with(compact('orders', 'borrowedList', 'missingList'));
    }

    public function borrowItem()
    {
        return view('pages.admin.borrowItem');
    }

    public function addItem($id)
    {
        $item = Item::select('items.*', 'brands.brand_name as brand', 'models.model_name as model')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->find($id);

            $itemQuantity = $item->quantity;
        
            
            $lostItemQuantity = Itemlog::where('item_id', $id)->sum('quantity');
            $borrowedQuantity = OrderItem::where('item_id', $id)->where('status', 'borrowed')->sum('order_quantity');
        
          
            $availableQuantity = $itemQuantity - $lostItemQuantity - $borrowedQuantity;

            $data = [
                'item' => $item,
                'availableQuantity' => $availableQuantity,
            ];
        

        return response()->json($data);
    }

    public function pendingBorrow(Request $request)
    {
        $userID = $request->userID;
        $itemId = $request->itemId;
        $serialNumber = $request->serialNumber;
        $duration = $request->duration;

        $dataOrder = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.user_id', $userID)
        ->whereNotNull('orders.date_submitted')
        ->whereNull('orders.approved_by')
        ->count();

        if ($dataOrder === 0) {
            $insertOrder = Order::create([
                'user_id' => $userID,
                'created_by' => 'admin',
                'date_submitted' => Carbon::today()
            ]);
            if ($insertOrder) {
                $orderId = $insertOrder->id;
                Item::where('serial_number', '=', $serialNumber)->update(['borrowed' => 'yes']);
                OrderItemTemp::create([
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => 1,
                    'temp_duration' => $duration,
                    'order_serial_number' => $serialNumber
                ]);
            }
        } else {
            $order = $dataOrder->first();
            $orderId = $order->id;
            Item::where('serial_number', '=', $serialNumber)->update(['borrowed' => 'yes']);
            OrderItemTemp::create([
                'order_id' => $orderId,
                'item_id' => $itemId,
                'quantity' => 1,
                'temp_duration' => $duration,
                'temp_serial_number' => $serialNumber
            ]);
        }
        return response()->json(['success' => true]);
    }

    public function userPendingBorrow(Request $request)
    {
        $userID = $request->userID;
        $itemId = $request->itemId;
        $order_id_user = $request->order_id_user;
        $serialNumber = $request->serialNumber;
        $duration = $request->duration;

        
  
      
       OrderItemTemp::create([
        'order_id' => $order_id_user,
        'item_id'=> $itemId,
        'temp_serial_number' => $serialNumber,
        'temp_duration' => $duration,
        'quantity' => 1
       ]);
      
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
        $duration = $request->duration;

        // dd($request->all());

        $dataOrder = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->whereNotNull('orders.date_submitted')
            ->whereNull('orders.approved_by')
            ->count();

 

        if ($dataOrder == 0) {
            $insertOrder = Order::create([
                'user_id' => $userId,
                'created_by' => 'admin',
                'date_submitted' => Carbon::today()
            ]);

            if ($insertOrder) {
                $orderId = $insertOrder->id;
                OrderItemTemp::create([
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => $orderQuantity,
                    'temp_duration' => $duration,
                    'temp_serial_number' => $serial
                ]);
            }
        } else {
            $orderId = $dataOrder->first()->id;
            OrderItemTemp::create([
                'order_id' => $orderId,
                'item_id' => $itemId,
                'quantity' => $orderQuantity,
                'temp_duration' => $duration,
                'temp_serial_number' => $serial
            ]);
        }
        return response()->json(['success' => true]);
    }
    public function borrowItemAdmin($id)
    {

        $count = Order::join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->select('orders.id as order_id', 'brands.*', 'models.*', 'users.*', 'order_items.order_quantity as order_quantity', 'order_items.id as order_item_id', 'order_items.user_id as user_id', 'items.*', 'item_categories.*')
            ->where('users.id_number', $id)
            ->where('order_items.status', 'pending')
            ->count();
        if($count == 0){
            return redirect('pending');

        }else{
            $order = Order::join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', '=', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->select('orders.id as order_id', 'brands.*', 'models.*', 'users.*', 'order_items.order_quantity as order_quantity', 'order_items.id as order_item_id', 'order_items.user_id as user_id', 'items.*', 'item_categories.*', 'items.id as item_id', 'order_items.*')
            ->where('users.id_number', $id)
            ->where('order_items.status', 'pending')
            ->get();
            

        return view('pages.admin.borrowItemAdmin')->with(compact('order'));
        }

       
    }


    public function checkUserId($id)
    {
        $checkUser = Order::where('user_id', $id)
            ->whereNull('approval_date')
            ->get();

        if ($checkUser->count() > 0) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

 

    public function submitAdminBorrow(Request $request)
    {
        $orderIds = $request->order_id;
        $orderItemId = $request->order_item_id;
        $quantity = $request->quantity;
        $currentDate = Carbon::now();
        $user = auth()->user();

        
        if($user){
            $firstName = $user->first_name;
            $lastName = $user->last_name;

            if (!empty($orderIds)) {
                Order::whereIn('id',$orderIds)->update([
                    'approval_date' => Carbon::today(),
                    'approved_by' => $firstName .' '. $lastName
                ]);

                foreach ($orderItemId as $index => $itemId ){
                    $getItemId = OrderItem::where('id', $orderItemId[$index])
                                ->first();
                    $itemId = $getItemId->item_id;
                    $item = Item::find($itemId);
                    $durationDay = $item->duration;
                    $dateReturn = $currentDate->copy()->addDays($durationDay);
                    
                    $orderItem = OrderItem::where('id', $orderItemId[$index])
                                    ->where('status', 'pending')
                                    ->update([
                                        'status' => 'borrowed',
                                        'date_returned' =>  $dateReturn->format('Y-m-d'),
                                        'released_by' => $lastName . ' ' . $firstName
                                    ]);
                }
                return response()->json(['success' => 'Successfully added borrowed item.']);
                  
            }else {
                return response()->json(['error' => 'Error: No order selected.']);
            }
        }


        
    }

    public function submitUserBorrow(Request $request)
    {
        $orderId = $request->input('order_id');
        $student_id_added_user = $request->input('student_id_added_user');
        $serialNumbers = $request->input('user_serial_number');
        $description = $request->input('description');
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

                    if ($value != 'N/A') {

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


        $existingItems = Item::whereIn('serial_number', $serialNumbers)
            ->whereIn('description', $description)
            ->where('borrowed', 'no')
            ->get();
    
        foreach ($serialNumbers as $serialNumber) {
                if ($serialNumber !== 'N/A') { 
                    $item = $existingItems->where('serial_number', $serialNumber)->first();
                    if (!$item) {
                        return response()->json(['error' => "Serial number '$serialNumber' does not exist in the item table or does not match the provided description."]);
                    }
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
               
                
                $item = Item::find($itemId[$index]);
              
                if (isset($itemId[$index]) && isset($quantity[$index]) && isset($serialNumbers[$index])) {
                    $order = $orderId[$index];
                    $durationDay = $duration[$index];

                
                    $dateReturn = $currentDate->copy()->addDays($durationDay);
                   
                    
                    if ($item->serial_number === 'N/A') {
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
                            Item::where('id', $itemId[$index])->update(['borrowed' => 'yes']);
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
                                        
                    }
              

                }
            
        }
   

        return response()->json(['success' => 'Serial numbers are valid.']);
    }
}









    public function adminNewOrder(Request $request)
    {
        $userId = $request->userId;
        $itemId = $request->itemId;
        $orderId = $request->orderId;
        $brand = $request->brand;
        $model = $request->model;
        $description = $request->description;
        $serial = $request->serial;
        $quantity = $request->quantity;

        $user = auth()->user();

        if ($user) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            Item::where('serial_number', $serial)->update(['borrowed' => 'yes']);
            OrderItem::create([
                'order_id' => $orderId,
                'user_id' => $userId,
                'item_id' => $itemId,
                'quantity' => $quantity,
                'status' => 'pending',
                'released_by' => $firstName . ' ' . $lastName,
                'order_serial_number' => $serial
            ]);
            return response()->json(['success' => 'Successfully added borrowed item.']);
        }
    }

    public function userNewOrder(Request $request)
    {
       
        $itemId = $request->itemId;
        $orderId = $request->order_id_user;
        $serial = $request->serial;
        $orderQuantity = $request->quantity;
        $duration = $request->duration;


       OrderItemTemp::create([
        'order_id' => $orderId,
        'item_id'=> $itemId,
        'temp_serial_number' => 'N/A',
        'temp_duration' => $duration,
        'quantity' => $orderQuantity
       ]);
      
        return response()->json(['success' => true]);



        // $dataOrder = Order::where('user_id', $userId)
        //     ->whereNotNull('date_submitted')
        //     ->whereNull('date_returned')
        //     ->get();

        // if ($dataOrder->isEmpty()) {
        //     $insertOrder = Order::create([
        //         'user_id' => $userId,
        //         'created_by' => 'user',
        //         'date_submitted' => Carbon::today()
        //     ]);

        //     if ($insertOrder) {
        //         $orderId = $insertOrder->id;
        //         OrderItemTemp::create([
        //             'order_id' => $orderId,
        //             'item_id' => $itemId,
        //             'quantity' => $orderQuantity,
        //             'temp_serial_number' => 'N/A'
        //         ]);
        //     }
        // } else {
        //     $orderId = $dataOrder->first()->id;
        //     OrderItemTemp::create([
        //         'order_id' => $orderId,
        //         'item_id' => $itemId,
        //         'quantity' => $orderQuantity,
        //         'temp_serial_number' => 'N/A'
        //     ]);
        // }
        // return response()->json(['success' => true]);
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

  
}
