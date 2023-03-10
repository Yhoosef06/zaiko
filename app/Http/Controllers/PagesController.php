<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PagesController extends Controller
{
    public function index()
    {
        //admin
        return view('pages.admin.home');
    }

    public function approve(){
        //unapproved
        return view('others.approve');
    }
}
