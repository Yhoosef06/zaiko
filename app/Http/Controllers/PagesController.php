<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\User;
use App\Models\College;
use App\Models\Department;
use App\Models\ItemCategory;
use App\Models\ItemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index()
    {
        if (Auth::user()->account_type == 'admin') {
            $totalQuantity = Item::sum('quantity');
            $users = User::all();
            $missingItems = ItemLog::where('mode', 'missing')->get();
            $totalMissingItems = $missingItems->count();
            return view('pages.admin.adminDashboard')->with(compact('totalQuantity', 'totalMissingItems'));
        } elseif (Auth::user()->role == 'manager') {
            $manager_dept_id = Auth::user()->department_id;
            $pendingRegistrants = User::where('account_status', 'pending')
                ->where('department_id', $manager_dept_id)
                ->get();
            $totalPendingRegistrants = $pendingRegistrants->count();
            return view('pages.admin.managerDashboard')->with(compact('totalPendingRegistrants'));
        }
    }

    public function approve()
    {
        //unapproved
        return view('pages.others.approve');
    }
}
