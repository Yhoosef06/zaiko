<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    public function index(){
        return view('pages.students.home');
    }

    public function items(){
        $items = Item::all();

        return view('pages.students.items',compact('items'));
    }


    public function borrow(){
        return view('pages.students.borrowitems');
    }

    public function viewItemDetails($serial_number)
    {
        $item = Item::find($serial_number);
        return view('pages.students.viewItem')->with('item', $item);
    }

    public function agreement(){
        return view('pages.students.agreement');
    }

}
