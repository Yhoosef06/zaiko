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
        // $user = auth()->user();
        // $user_dept_id = $user->department_id;
        // $department = Department::with('college')->find($user_dept_id);
        // $college = $department->college;

        $userId = auth()->user()->id_number;
        $user = User::find($userId);

        if ($user->roles->contains('name', 'admin')) {
            $totalItems = Item::where('parent_item', null)
                ->sum('quantity');
            $users = User::all();
            $totalUsers = $users->count();
            $totalMissingItems = ItemLog::where('mode', 'missing')
                ->sum('quantity');
            $borrowedItems = OrderItem::where('status', 'borrowed')
                ->sum('order_quantity');
            return view('pages.admin.adminDashboard')->with(compact('totalItems', 'totalMissingItems', 'totalUsers', 'borrowedItems'));
        } else {
            // $manager_dept_id = Auth::user()->department_id;
            // $room_dept_id = Room::where('department_id', $manager_dept_id);
            // $pendingRegistrants = User::where('account_status', 'pending')
            //     ->where('department_id', $manager_dept_id)
            //     ->get();
            // $approvedUsers = User::where('account_status', 'approved')
            //     ->where('department_id', $manager_dept_id)
            //     ->get();
            // $items = Item::whereHas('room', function ($query) use ($manager_dept_id) {
            //     $query->where('department_id', $manager_dept_id)
            //         ->where('parent_item', null);
            // })->get();
            // $borrowedItems = Order::select('orders.id as transactionId', 'orders.*', 'users.*')
            //     ->join('users', 'orders.user_id', '=', 'users.id_number')
            //     ->join('departments', 'users.department_id', '=', 'departments.id')
            //     ->join('colleges', 'departments.college_id', '=', 'colleges.id')
            //     ->where('colleges.id', $college->id)
            //     ->WhereNull('orders.order_status')
            //     ->whereNotNull('orders.approval_date')
            //     ->whereNotNull('orders.approved_by')
            //     ->groupBy('orders.id')
            //     ->get();
            // $borrowPendings = Order::select('orders.id as transactionId', 'orders.*', 'users.*')
            //     ->join('users', 'orders.user_id', '=', 'users.id_number')
            //     ->join('departments', 'users.department_id', '=', 'departments.id')
            //     ->join('colleges', 'departments.college_id', '=', 'colleges.id')
            //     ->where('colleges.id', $college->id)
            //     ->whereNotNull('orders.date_submitted')
            //     ->whereNull('orders.approved_by')
            //     ->groupBy('orders.id')
            //     ->get();

            // $totalborrowedItems = $borrowedItems->count();
            // $totalBorrowPendings = $borrowPendings->count();
            // $totalItems = $items->count();
            // $totalPendingRegistrants = $pendingRegistrants->count();
            // $totalApprovedUsers = $approvedUsers->count();
            // return view('pages.admin.managerDashboard')->with(compact('totalBorrowPendings','totalborrowedItems', 'totalPendingRegistrants', 'totalApprovedUsers', 'totalItems'));
            return view('pages.admin.managerDashboard');
        }
    }

    public function approve()
    {
        //unapproved
        return view('pages.others.approve');
    }
}
