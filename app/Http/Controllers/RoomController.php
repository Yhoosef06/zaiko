<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{

    public function index()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $rooms = Room::all();
            $departments = Department::all();
            return view('pages.admin.listOfRooms')->with(compact('rooms', 'departments'));
        } else {
            $departments = Department::all();
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            return view('pages.admin.listOfRooms')->with(compact('rooms', 'departments'));
        }
    }

    public function addNewRoom()
    {
        return view('pages.admin.addRoom');
    }

    // public function storeNewRoom(Request $request)
    // {
    //     $roomName = $request->input('room_name');
    //     $this->validate(
    //         $request,
    //         [
    //             'room_name' => 'required|regex:/[A-Z]+/|min:3'
    //         ]
    //     );
    //     $room = Room::where('room_name', '=', $request->input('room_name'))->first();
    //     if (Auth::user()->account_type == 'admin') {
    //         if ($room === null) {
    //             Room::create([
    //                 'room_name' => $request->room_name,
    //                 'department_id' => $request->department
    //             ]);
    //             Session::flash('success', 'Room ' . $request->room_name . ' Successfully Added.');
    //             return redirect('adding-new-item');
    //         } else {
    //             Session::flash('status', 'Room ' . $request->room_name . ' has already been added.');
    //             return redirect('adding-new-item');
    //         }
    //     } else {
    //         if ($room === null) {
    //             Room::create([
    //                 'room_name' => $roomName,
    //                 'department_id' => Auth::user()->department_id
    //             ]);
    //             Session::flash('success', 'Room ' . $request->room_name . ' Successfully Added.');
    //             return redirect('adding-new-item');
    //         } else {
    //             Session::flash('status', 'Room ' . $request->room_name . ' has already been added.');
    //             return redirect('adding-new-item');
    //         }
    //     }
    // }

    public function storeNewRoom(Request $request)
    {
        // Validate the input
        $request->validate([
            'room_name' => 'required|regex:/[A-Z]+/|min:3',
            'department' => Auth::user()->account_type == 'admin' ? 'required|exists:departments,id' : '',
        ]);

        // Check if the room already exists
        $room = Room::where('room_name', $request->input('room_name'))->first();
        if ($room) {
           return response()->json(['error' => 'Room has already been added.'], 400);
        }

        // Create a new room
        $departmentId = Auth::user()->account_type == 'admin' ? $request->input('department') : Auth::user()->department_id;
        $room = Room::create([
            'room_name' => $request->input('room_name'),
            'department_id' => $departmentId,
        ]);

        // Return a success message
        return response()->json(['success' => $room->room_name . ' Successfully Added.'], 200);
    }
}
