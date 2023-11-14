<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowerController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now();
        $department = Auth::user()->departments->first();
        
        // $items = OrderItem::where('user_id',Auth::user()->id_number)->where('date_returned', '<', $currentDate->toDateString())->get();
        // dd($items);

        $overdueItems = Order::select('orders.id as order_id', 'users.*', 'brands.brand_name as brand', 'models.model_name as model', 'order_items.id as order_item_id', 'order_items.*', 'items.*', 'item_categories.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('user_departments', 'users.id_number', '=', 'user_departments.user_id_number')
            ->join('departments', 'user_departments.department_id', '=', 'departments.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->where('order_items.user_id', Auth::user()->id_number)
            ->where('order_items.date_returned', '<', $currentDate->toDateString())
            ->where('departments.college_id', $department->college_id)
            ->where('order_items.status', 'borrowed')
            ->get();

        foreach ($overdueItems as $item) {
            $dateReturned = Carbon::parse($item->date_returned); 
            $daysOverdue = $dateReturned->diffInDays($currentDate);
            $item->days_overdue = $daysOverdue;
        }
        // dd($overdueItems);  
        return view('pages.students.home')->with(compact('overdueItems'));
    }

    // public function items()
    // {
    //     $categories = ItemCategory::all();
    //     $itemlogs = ItemLog::all();
    //     $borrowedList = OrderItem::where('status', 'borrowed')->get();
    //     $missingList = ItemLog::where('mode', 'missing')->get();
    //     $departments = Department::all();

    //     return view('pages.students.items')->with(compact('departments','categories', 'itemlogs', 'borrowedList', 'missingList', 'departments'));
    // }

    public function department_selected(Request $request){

        $categories = ItemCategory::all();
        $itemlogs = ItemLog::all();
        $borrowedList = OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();
        $departments = Department::all();
        $departmentId = $request->department;
        // Fetch items based on the selected department
        $items = Item::whereHas('room.department', function ($query) use ($departmentId) {
            $query->where('id', $departmentId);
        })->get();
        


        // Pass the data to the view
        return view('pages.students.items')->with(compact('departments','departmentId', 'categories', 'itemlogs', 'borrowedList', 'missingList', 'items'));
    }

    // return view('pages.students.items')->with(compact('items', 'categories', 'itemlogs', 'borrowedList', 'missingList', 'departments'));

    // public function filterItems(Request $request, $departmentId)
    // {
    //     $categories = ItemCategory::all();
    //     $itemlogs = ItemLog::all();
    //     $borrowedList = OrderItem::where('status', 'borrowed')->get();
    //     $missingList = ItemLog::where('mode', 'missing')->get();
    //     $items = Item::whereHas('room.department', function ($query) use ($departmentId) {
    //         $query->where('id', $departmentId)->get();
    //     });

    //     // You can create a partial view for the item list and return it
    //     return view('students.filteritems')->with(compact('items','categories','itemLogs','borrowedList','missingList'));
    // }


    public function borrow()
    {
        return view('pages.students.borrowitems');
    }

    public function viewItemDetails($serial_number)
    {
        $item = Item::find($serial_number);
        return view('pages.students.viewItem')->with('item', $item);
    }

    public function pending(){
        
        $pendingOrder = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNull('date_returned')->get();

        dd($pendingOrder);

        return view('pages.students.pending')->with(compact('pendingOrder'));
    }

    public function agreement()
    {
        return view('pages.students.agreement');
    }

    public function agreement_approve($id)
    {
        $user = User::find($id);

        $user->agreement = true;
        $user->agreement_date = Carbon::now()->format('Y-m-d');
        $user->update();

        return redirect()->route('cart.list');


        // public function pendingItem($serial_number){
        //     $affectedRows = Order::where('serial_number','=',$serial_number)->update(['order_status' => 'borrowed']);


        //     Session::flash('success', 'Borrow has been Approved.');

        //     return redirect('pending');
        // }
    }

    public function overdue()
    {
        $currentDate = Carbon::now();
        $department = Auth::user()->departments->first();
    
        $overdueItems = Order::select('orders.id as order_id', 'users.*', 'brands.brand_name as brand', 'models.model_name as model', 'order_items.id as order_item_id', 'order_items.*', 'items.*', 'item_categories.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('user_departments', 'users.id_number', '=', 'user_departments.user_id_number')
            ->join('departments', 'user_departments.department_id', '=', 'departments.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('item_categories', 'items.category_id', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->where('order_items.date_returned', '<', $currentDate->toDateString())
            ->where('departments.college_id', $department->college_id)
            ->where('order_items.status', 'borrowed')
            ->get();
    
        
        foreach ($overdueItems as $item) {
            $dateReturned = Carbon::parse($item->date_returned); 
            $daysOverdue = $dateReturned->diffInDays($currentDate);
            $item->days_overdue = $daysOverdue;
        }
    
        return view('pages.admin.overdue')->with(compact('overdueItems'));
    }
}
