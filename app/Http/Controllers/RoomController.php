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
        if (Auth::user()->roles->contains('name', 'admin')) {
            $rooms = Room::paginate(10);
            return view('pages.admin.listOfRooms')->with(compact('rooms'));
        } else {
            $user = Auth::user();
            $departments = $user->departments;
            $rooms = Room::where('department_id', $departments->pluck('id'))->with('department')->withCount('items')->get();
            return view('pages.admin.listOfRooms')->with(compact('rooms'));
        }
    }

    public function addRoom()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $colleges = College::with('departments')->get();
            $departments = Department::with('college')->get();
            return view('pages.admin.addRoom')->with(compact('departments', 'colleges'));
        } elseif ($user->hasRole('manager')) {
            $departments = $user->departments()->with('college')->get();
            $collegeIds = $departments->pluck('college.id')->unique();
            $colleges = College::whereIn('id', $collegeIds)->get();

            return view('pages.admin.addRoom')->with(compact('departments', 'colleges'));
        } else {
            abort(403, 'Unauthorized action.');
        }
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

            return back()->with('success', 'Room name added successfully!');
        } catch (\Exception $e) {
            return back()->with('danger', 'An error occurred while adding the room name.');
        }
    }

    public function editRoom($id)
    {
        if (Auth::user()->account_type == 'admin') {
            $room = Room::find($id);
            $departments = Department::with('college')->get();

            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });
            return view('pages.admin.editRoom')->with(compact('room', 'departments'));
        } else {

            $room = Room::find($id);
            $room_dept_id = $room->department_id;
            $room_department = Department::find($room_dept_id);
            $room_college_id = $room_department->college_id;
            $departments = Department::with('college')->where('college_id', $room_college_id)->get();
            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });

            return view('pages.admin.editRoom')->with(compact('room', 'departments'));
        }
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
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove room because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('rooms');
        }
    }
}
