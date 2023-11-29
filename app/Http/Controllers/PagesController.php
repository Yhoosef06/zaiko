<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Role;
use App\Models\Room;
use App\Models\Term;
use App\Models\User;
use App\Models\Order;
use App\Models\College;
use App\Models\ItemLog;
use App\Models\OrderItem;
use App\Models\Department;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index()
    {
        $term = Term::where("isCurrent", true)->first();
        $userId = auth()->user()->id_number;
        $department = Auth::user()->departments->first();
        $currentDate = Carbon::now();

        $user = User::find($userId);
        if ($user->roles->contains('name', 'admin')) {
            $totalItems = Item::where('parent_item', null)
                ->sum('quantity');
            $users = User::all();
            $totalUsers = $users->count();
            $activeUsers = $users->where('isActive', true)->count();
            $inactiveUsers = $users->where('isActive', false)->count();
            return view('pages.admin.adminDashboard')->with(compact('totalItems', 'inactiveUsers', 'totalUsers', 'activeUsers', 'term'));
        } else if ($user->roles->contains('name', 'manager')) {
            $departmentIds = $user->departments->pluck('id');
            $college = $user->departments->first()->college;

            $room_dept_id = Room::whereIn('department_id', $departmentIds)->get();

      

            $items = Item::whereHas('room', function ($query) use ($departmentIds) {
                $query->whereIn('department_id', $departmentIds)
                    ->where('parent_item', null);
            })->get();

            if($department->college_id === 5 ){

                
            $userpendings = Order::select('orders.id as transactionId', 'orders.*', 'users.*', 'items.*', 'rooms.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_item_temps', 'orders.id', '=', 'order_item_temps.order_id')
            ->join('items', 'order_item_temps.item_id', '=', 'items.id')
            ->join('rooms', 'items.location', '=', 'rooms.id')
            ->where('rooms.college_id', $department->college_id)
            ->whereNull('orders.approval_date')
            ->whereNull('orders.approved_by')
            ->groupBy('orders.id')
            ->get();

            $borrows = Order::select('orders.id as transactionId', 'orders.*', 'users.*', 'items.*', 'rooms.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_item_temps', 'orders.id', '=', 'order_item_temps.order_id')
            ->join('items', 'order_item_temps.item_id', '=', 'items.id')
            ->join('rooms', 'items.location', '=', 'rooms.id')
            ->where('rooms.college_id', $department->college_id)
            ->WhereNull('orders.order_status')
            ->whereNotNull('orders.approval_date')
            ->whereNotNull('orders.approved_by')
            ->groupBy('orders.id')
            ->get();

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
            ->where('rooms.college_id', $department->college_id)
            ->get();

            $countBorrow = $borrows->count();
            $pendings =  $userpendings->count();
            $overdue = $overdueItems->count();
         
                session([
                    'pending_count' => $pendings,
                    'borrow_count' => $countBorrow,
                    'overdue_count' => $overdue
                    ]);
            
            
           

            $totalItems = $items->count();

            return view('pages.admin.managerDashboard')->with(compact('totalItems','pendings','countBorrow', 'overdue'));

            }else{
                
            $userpendings = Order::select('orders.id as transactionId', 'orders.*', 'users.*', 'items.*', 'rooms.*')
            ->join('users', 'orders.user_id', '=', 'users.id_number')
            ->join('order_item_temps', 'orders.id', '=', 'order_item_temps.order_id')
            ->join('items', 'order_item_temps.item_id', '=', 'items.id')
            ->join('rooms', 'items.location', '=', 'rooms.id')
            ->where('rooms.department_id', $department->id)
            ->whereNull('orders.approval_date')
            ->whereNull('orders.approved_by')
            ->groupBy('orders.id')
            ->get();

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

            $countBorrow = $borrows->count();
            $pendings =  $userpendings->count();
            $overdue = $overdueItems->count();
         
                session([
                    'pending_count' => $pendings,
                    'borrow_count' => $countBorrow,
                    'overdue_count' => $overdue
                    ]);
            
            
           

            $totalItems = $items->count();

            return view('pages.admin.managerDashboard')->with(compact('totalItems','pendings','countBorrow', 'overdue'));
            }

            

        }
    }

    public function approve()
    {
        //unapproved
        return view('pages.others.approve');
    }
}
