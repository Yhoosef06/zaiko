<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        return view('pages.students.home');
    }

    public function borrow(){
        return view('pages.students.home');
    }

}
