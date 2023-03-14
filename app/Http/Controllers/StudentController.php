<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    public function index(){
        return view('pages.students.home');
    }

    public function items(){
        // $items = DB::table('items')->get();
        // return View::make("/items",compact('items'));
        return view('pages.students.items');
    }

    public function borrow(){
        return view('pages.students.home');
    }

}
