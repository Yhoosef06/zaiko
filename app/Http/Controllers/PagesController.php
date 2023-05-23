<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\College;
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
        //admin
        return view('pages.admin.dashboard');
    }

    public function approve()
    {
        //unapproved
        return view('pages.others.approve');
    }

    public function test()
    {

        $categories = ItemCategory::all();
        $user_dept_id = Auth::user()->department_id;
        $rooms = Room::where('department_id', $user_dept_id)->get();
        $items = Item::whereIn('location', $rooms->pluck('id'))->get();

        return view('pages.students.test', compact('categories', 'items'));
    }


    public function addItem()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $rooms = Room::all();
            $itemCategories = ItemCategory::all();
            $departments = Department::with('college')->get();
            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });
            $colleges = College::with('departments')->orderBy('college_name')->get();
            return view('pages.admin.addItem')->with(compact('rooms', 'itemCategories', 'departments', 'colleges'));
        } else {
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            $itemCategories = ItemCategory::all();
            return view('pages.admin.addItem')->with(compact('rooms', 'itemCategories'));
        }
    }
}
