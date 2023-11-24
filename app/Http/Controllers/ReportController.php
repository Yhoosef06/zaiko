<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\ItemLog;
use App\Models\Reference;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function generateReportPage()
    {
        //admin
        if (Auth::user()->roles->contains('name', 'admin')) {
            $rooms = Room::all();
            return view('pages.reports.generate')->with(compact('rooms'));
        } else {
            $departmentIds = Auth::user()->departments->pluck('id');
            $rooms = Room::whereIn('department_id', $departmentIds)->get();
            return view('pages.reports.generate')->with(compact('rooms'));
        }
    }
    public function downloadReport(Request $request)
    {   
        $this->validate(
            $request,
            [
                'location' => 'required',
                'status' => 'required',
                'prepared_by' => 'required',
                'verified_by' => 'required',
                'noted_by' => 'required',
                'approved_by' => 'required',
                'role_1' => 'required',
                'role_2' => 'required',
                'role_3' => 'required',
                'role_4' => 'required'
            ]
        );

        $location = $request->location;
        $status = $request->status;
        $prepared_by = $request->prepared_by;
        $verified_by = $request->verified_by;
        $noted_by = $request->noted_by;
        $approved_by = $request->approved_by;
        $role_1 = $request->role_1;
        $role_2 = $request->role_2;
        $role_3 = $request->role_3;
        $role_4 = $request->role_4;

        $itemLog = ItemLog::where('mode', $status)->get();
        $isLog = !itemLog::where('mode', $status)->get()->isEmpty();
        $isStatus = !Item::where('location', $status)->get()->isEmpty();

        $user_dept_id = Auth::user()->department_id;
        if (Auth::user()->account_status == 'admin') {
            $rooms = Room::all();

            $items = Item::where('location', $location)->get();
            $room = Room::where('id', '=', $location)->get();

            foreach ($room as $index) {
                $dept_id = $index->department_id;
            }
            $department = Department::find($dept_id);

            $department = $department->department_name;
        } else {
            $rooms = Room::where('department_id', $user_dept_id)->get();
            $rooms = Room::all();

            $items = Item::where('location', $location)
            ->where('status', $status)
            ->get();
            
            if ($items->isEmpty()) {
                $itemLogs = ItemLog::where('mode', $status)->get();
            }

            $room = Room::where('id', '=', $location)->get();

            foreach ($room as $index) {
                $dept_id = $index->department_id;
            }
            $department = Department::find($dept_id);

            $department = $department->department_name;
        }

        if ($request->has('download')) {
            // $pdf = App::make('dompdf.wrapper');
            // $pdf->loadView(
            //     'pages.reports.pdfReport',
            //     compact(
            //         'items',
            //         'status',
            //         'location',
            //         'prepared_by',
            //         'verified_by',
            //         'noted_by',
            //         'approved_by',
            //         'department',
            //         'rooms',
            //         'role_1',
            //         'role_2',
            //         'role_3',
            //         'role_4',
            //         'isLog',
            //         'isStatus',
            //         'itemLog'
            //     )
            // )->setOptions(['defaultFont' => 'sans-serif',])->setPaper('a4');
            // Reference::create([
            //     'location' => $request->location,
            //     'prepared_by' => $request->prepared_by,
            //     'verified_by' => $request->verified_by,
            //     'noted_by' => $request->noted_by,
            //     'approved_by' => $request->approved_by,
            //     'role_1' => $request->role_1,
            //     'role_2' => $request->role_2,
            //     'role_3' => $request->role_3,
            //     'role_4' => $request->role_4,
            // ]);
            return view('pages.reports.pdfReport')->with(
                compact(
                    'items',
                    'itemLog',
                    'status',
                    'location',
                    'prepared_by',
                    'verified_by',
                    'noted_by',
                    'approved_by',
                    'department',
                    'rooms',
                    'role_1',
                    'role_2',
                    'role_3',
                    'role_4',
                    'isLog',
                    'isStatus'
                )
            );
            foreach ($rooms as $room) {
                if ($room->id == $location)
                    return $pdf->download('InventoryReport' . $room->room_name . '.pdf');
            }
        }
    }
}
