<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(){
        return view('pages.students.home');
    }

    public function items(){
        $categories = ItemCategory::all();
        $user_dept_id = Auth::user()->department_id;
        $rooms = Room::where('department_id', $user_dept_id)->get();
        $items = Item::whereIn('location', $rooms->pluck('id'))->get();

        return view('pages.students.items',compact('categories','items'));     
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

    public function agreement_approve($id){
        $user = User::find($id);

        $user->agreement = true;
        $user->agreement_date = Carbon::now()->format('Y-m-d');
        $user->update();

        return redirect()->route('cart.list');


        // public function pendingItem($serial_number){
        //     $affectedRows = Order::where('serial_number','=',$serial_number)->update(['order_status' => 'borrowed']);
           
           
        //     Session::flash('success', 'Borrow has been Approved.');
        
        //     return redirect('pending');
        // }
    }

    public function borrowList(){
        echo 'test';

    }

}
