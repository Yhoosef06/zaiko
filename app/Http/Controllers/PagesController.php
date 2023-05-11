<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Item;
use App\Models\Room;
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
        return view('pages.students.test');
    }


    public function addItem()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $rooms = Room::all();
            $itemCategories = ItemCategory::all();
            // $data = Department::select('department_name', 'college_id')->orderBy('id')->groupBy('department_name', 'college_id')->get();
            // // dd($data);
            $departments = Department::all();
            return view('pages.admin.addItem')->with(compact('rooms', 'itemCategories', 'departments'));
        } else {
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            $itemCategories = ItemCategory::all();
            return view('pages.admin.addItem')->with(compact('rooms', 'itemCategories'));
        }
    }
}
