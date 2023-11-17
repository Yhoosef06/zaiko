<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Role;
use App\Models\Room;
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
        $userId = auth()->user()->id_number;
        $department = Auth::user()->departments->first();

        $user = User::find($userId);
        if ($user->roles->contains('name', 'admin')) {
            $totalItems = Item::where('parent_item', null)
                ->sum('quantity');
            $users = User::all();
            $totalUsers = $users->count();
            $activeUsers = $users->where('isActive', true)->count();
            $inactiveUsers = $users->where('isActive', false)->count();
            return view('pages.admin.adminDashboard')->with(compact('totalItems', 'inactiveUsers', 'totalUsers', 'activeUsers'));
        } else if ($user->roles->contains('name', 'manager')) {
            $departmentIds = $user->departments->pluck('id');
            $college = $user->departments->first()->college;

            $room_dept_id = Room::whereIn('department_id', $departmentIds)->get();

            $items = Item::whereHas('room', function ($query) use ($departmentIds) {
                $query->whereIn('department_id', $departmentIds)
                    ->where('parent_item', null);
            })->get();

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
            $pendings =  $userpendings->count();
            session(['pending_count' => $pendings]);
           

            $totalItems = $items->count();

            return view('pages.admin.managerDashboard')->with(compact('totalItems','pendings'));
        }
    }

    public function approve()
    {
        //unapproved
        return view('pages.others.approve');
    }
}
