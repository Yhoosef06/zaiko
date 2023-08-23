<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{

    public function index()
    {
        if (Auth::user()->account_type == 'admin') {
            $rooms = Room::with('department')->withCount('items')->get();
            return view('pages.admin.listOfRooms')->with(compact('rooms'));
        } else {
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->with('department')->withCount('items')->get();
            return view('pages.admin.listOfRooms')->with(compact('rooms'));
        }
    }

    public function addRoom()
    {
        $colleges = College::all();
        $departments = Department::with('college')->get();
        $departments->each(function ($department) {
            $department->college_name = $department->college->college_name;
        });
        return view('pages.admin.addRoom')->with(compact('departments', 'colleges'));
    }

    public function saveNewRoom(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'room_name' => 'required|unique:rooms,room_name',
                ],
            );

            Room::create([
                'college_id' => $request->college_id,
                'department_id' => $request->department_id,
                'room_name' => $request->room_name,
            ]);

            return redirect()->route('view_rooms')->with('success', 'Room name added successfully!');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->route('view_rooms')->with('danger', 'An error occurred while adding the room name.');
        }
    }

    public function storeNewRoom(Request $request)
    {
        // Validate the input
        $request->validate([
            'room_name' => 'required|regex:/[A-Z]+/|min:3',
            'department' => Auth::user()->account_type == 'admin' ? 'required|exists:departments,id' : '',

        ]);

        // Check if the room already exists
        $room_input = Room::where('room_name', $request->input('room_name'))->first();

        $departmentId = Auth::user()->account_type == 'admin' ? $request->input('department') : Auth::user()->department_id;

        if ($room_input) {

            return response()->json(['error' =>  $room_input . ' has already been added.'], 400);
        }

        $room = Room::create([
            'room_name' => $request->input('room_name'),
            'department_id' => $departmentId,
        ]);

        // Return a success message
        return response()->json([
            'success' => $room->room_name . ' successfully added.',
            'errors' => [
                'department' => ['The department field is required.'],
                'room_name' => ['The room name field is required.']
            ]
        ], 200);
    }

    public function editRoom($id)
    {
        $departments = Department::all();
        $room = Room::find($id);
        return view('pages.admin.editRoom')->with(compact('room', 'departments'));
    }

    public function saveEditedRoom(Request $request, $id)
    {
        try {
            $room = Room::find($id);

            if (!$room) {
                return redirect('rooms')->with('error', 'Room not found.');
            }

            $room->update([
                'department_id' => $request->department_id,
                'room_name' => $request->room_name,
                // Add other fields you want to update here
            ]);

            return redirect('rooms')->with('success', 'Room edited successfully.');
        } catch (\Exception $e) {
            return redirect('rooms')->with('danger', 'An error occurred while editing the room.');
        }
    }

    public function deleteRoom($id)
    {
        try {
            $room = Room::find($id);
            $room->delete();

            Session::flash('success', 'Room Successfully Removed');
            return redirect('rooms');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove room because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('rooms');
        }
    }
}
