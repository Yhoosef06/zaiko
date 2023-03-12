<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

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

    public function addItem()
    {
        //admin
        $rooms = Room::all();
        return view('pages.admin.addItem')->with(compact('rooms'));
    }
}
