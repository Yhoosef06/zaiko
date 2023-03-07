<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PagesController extends Controller
{
    public function index()
    {
        // dd(auth()->user());
        //admin
        return view('pages.home');
    }

    public function approve(){
        //unapproved
        return view('pages.others.approve');
    }

    public function test(){
        return view('pages.students.test');
    }
        

}
