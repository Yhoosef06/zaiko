<?php

namespace App\Http\Controllers;

use App\Models\Room;
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

    public function approve(){
        //unapproved
        return view('pages.others.approve');
    }

    public function test(){
        return view('pages.students.test');
    }
        

    public function addItem()
    {
        //admin
        $rooms = Room::all();
        return view('pages.admin.addItem')->with(compact('rooms'));
    }

    public function printPDF(Request $request){
        $room = Room::all();

        if($request->has('download'))
        {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pages.ind', compact('room'))->setOptions(['defaultFont' => 'sans-serif' ]);
            
            return $pdf->download('pdfView.pdf');
        }

        return view('pages.ind')->with(compact('room'));
    }
}