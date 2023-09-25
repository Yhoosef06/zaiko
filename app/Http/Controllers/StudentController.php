<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User;
use App\Models\Room;
use App\Models\Department;
use App\Models\College;
use App\Models\ItemLog;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    public function index()
    {
        return view('pages.students.home');
    }

    public function items()
    {

        $categories = ItemCategory::all();
        $user_dept_id = Auth::user()->department_id;
        $itemlogs = ItemLog::all();
        $borrowedList= OrderItem::where('status', 'borrowed')->get();
        $missingList = ItemLog::where('mode', 'missing')->get();

        // $rooms = Room::where('department_id', $user_dept_id)->get();x    x   
        // $items = Item::all();

        $departments = Department::with('college')->get();
        // $rooms = Room::with('departments')->get();
        // $items = Item::with('room')->get();

        // $departments->each(function ($department) {
        //     $department->college_name = $department->college->college_name;
        // });

        // foreach($items as $item){
        //     foreach($rooms as $room){
        //         foreach($departments as $department){
        //             if ($department->id == $user_dept_id){ 
        //                 $college =  $department->college->id;
        //                 dd($college);
        //             }
        //         }
        //     }
        // }   

        $collegeId = null;
        foreach ($departments as $department) {
            if ($department->id == $user_dept_id) {
                $collegeId =  $department->college->id;
                break;
            }
        }
        if($collegeId != null){
            $items = Item::whereHas('room.department.college', function ($query) use ($collegeId) {
                $query->where('id', $collegeId);
            })->get();
        }
        $items = Item::whereHas('room.department.college', function ($query) use ($collegeId) {
            $query->where('id', $collegeId);
        })->get();

        // dd($items);
        return view('pages.students.items')->with(compact('items','categories','itemlogs','borrowedList','missingList'));
    }


    public function borrow()
    {
        return view('pages.students.borrowitems');
    }

    public function viewItemDetails($serial_number)
    {
        $item = Item::find($serial_number);
        return view('pages.students.viewItem')->with('item', $item);
    }

    public function pending(){
        
        $pendingOrder = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNull('date_returned')->get();

        dd($pendingOrder);

        return view('pages.students.pending')->with(compact('pendingOrder'));
    }

    public function agreement()
    {
        return view('pages.students.agreement');
    }

    public function agreement_approve($id)
    {
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

    public function borrowed()
    {
        echo 'test';
    }

}
