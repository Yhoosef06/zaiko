<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

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
                'room_name' => 'required|regex:/[A-Z]/|min:3'
            ]
        );
        $room = Room::where('room_name', '=', $request->input('room_name'))->first();
        if ($room === null) {
            Room::create([
                'room_name' => $request->room_name
            ]);

            return redirect('adding-new-item')->with('status', 'New room added.');
        } else {
            return redirect('adding-room')->with('message', 'That room was already added.');
        }
    }
}
