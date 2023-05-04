<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
    public function addNewRoom()
    {
        return view('pages.admin.addRoom');
    }

    public function storeNewRoom(Request $request)
    {
        // dd($request);
        $this->validate(
            $request,
            [
                'room_name' => 'required|regex:/[A-Z]+/|min:3'
            ]
        );
        $room = Room::where('room_name', '=', $request->input('room_name'))->first();
        if ($room === null) {
            Room::create([
                'room_name' => $request->room_name,
                'department_id' => Auth::user()->department_id
            ]);
            Session::flash('success', 'Room '.$request->room_name.' Successfully Added.');
            return redirect('adding-new-item');
        } else {
            Session::flash('status', 'Room '.$request->room_name.' has already been added.');
            return redirect('adding-new-item');
        }
    }
}
