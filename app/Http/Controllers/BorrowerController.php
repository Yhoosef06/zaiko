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
use Illuminate\Support\Facades\Session;

class BorrowerController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now();
        // $department = Auth::user()->departments->first();
        // dd($department);

        $overdueItems = Order::select('orders.id as order_id', 'users.*', 'brands.brand_name as brand', 'models.model_name as model', 'order_items.id as order_item_id', 'order_items.*', 'items.*', 'item_categories.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            // ->join('user_departments', 'users.id_number', '=', 'user_departments.user_id_number')
            // ->join('departments', 'user_departments.department_id', '=', 'departments.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('rooms', 'items.location','=','rooms.id')
            ->join('item_categories', 'items.category_id', 'item_categories.id')
            ->join('models', 'items.model_id', '=', 'models.id')
            ->join('brands', 'models.brand_id', '=', 'brands.id')
            ->where('order_items.user_id', Auth::user()->id_number)
            ->where('order_items.date_returned', '<', $currentDate->toDateString())
            // ->where('rooms.college_id', $department->college_id)
            ->where('order_items.status', 'borrowed')
            ->get();
            // dd($overdueItems);

        foreach ($overdueItems as $item) {
            $dateReturned = Carbon::parse($item->date_returned); 
            $daysOverdue = $dateReturned->diffInDays($currentDate);
            $item->days_overdue = $daysOverdue;
        } 
        return view('pages.students.home')->with(compact('overdueItems'));
    }

    public function browse(){

        $departments = Department::whereHas('rooms.item', function ($query) {
             $query->where('status', '=', 'Active');
        })->get();
        // dd($departments);
        // $departments = Department::all();

        return view('pages.students.items')->with(compact('departments'));
    }

    public function browseDepartment(Request $request){

        $itemlogs = ItemLog::all();
        $borrowedList= OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();
        $selectedDepartment = $request->query('selectedDepartment');
        $items = Item::whereHas('room.department', function ($query) use ($selectedDepartment) {
            $query->where('id', $selectedDepartment);
        })->where('status','Active')->where('borrowed','no')->get();

        $categories = ItemCategory::all();
        $departments = Department::whereHas('rooms.item', function ($query) {
            $query->where('status', '=', 'Active');
        })->get();
        Session::put('department',$selectedDepartment);
        

        return view('pages.students.items')->with(compact('departments','categories','items','borrowedList','itemlogs','missingList'));
    }

    public function browseCategory(Request $request){

        $itemlogs = ItemLog::all();
        $borrowedList= OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();
        $selectedCategory = $request->category;
        $selectedDepartment = Session::get('department');
        $categories = ItemCategory::all();
        $departments = Department::whereHas('rooms.item', function ($query) {
            $query->where('status', '=', 'Active');
        })->get();
        Session::put('category',$selectedCategory);
        $sessionCat = Session::get('category',$selectedCategory);

        if(isset($selectedDepartment,$sessionCat)){
            if($sessionCat == 0){
                $items = Item::whereHas('room.department', function ($query) use ($selectedDepartment) {
                    $query->where('id', $selectedDepartment);
                })->where('status','Active')->where('borrowed','no')->get();
            }else{
                $items = Item::whereHas('room.department', function ($query) use ($selectedDepartment) {
                    $query->where('id', $selectedDepartment);
                })->where('category_id', $sessionCat)->where('status','Active')->where('borrowed','no')->get();
            }
        }else{
            if($sessionCat == 0){
                $items = Item::whereHas('room.department', function ($query) use ($selectedDepartment) {
                    $query->where('id', $selectedDepartment);
                })->where('status','Active')->where('borrowed','no')->get();
            }else{
                $items = Item::whereHas('room.department', function ($query) use ($selectedDepartment) {
                    $query->where('id', $selectedDepartment);
                })->where('category_id', $selectedCategory)->where('status','Active')->where('borrowed','no')->get();
            }
        }   

        return view('pages.students.items')->with(compact('departments','categories','items','borrowedList','itemlogs','missingList'));
    }

    public function browse_test(){

        $itemlogs = ItemLog::all();
        $borrowedList= OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();

        $items = Item::where('status','Active')->where('borrowed','no')->get();

        $groupedItems = $items->groupBy(function ($item) {
            return $item->brand_id . '-' . $item->model_id;
        });
        $departments = collect();    

        return view('pages.students.browse-items')->with(compact('groupedItems','itemlogs','borrowedList','missingList'));
    }




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
