<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\Term;
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
        $terms = Term::all();
        if (Auth::user()->roles->contains('name', 'admin')) {
            $rooms = Room::all();
            return view('pages.reports.generate')->with(compact('rooms', 'terms'));
        } else {
            $departmentIds = Auth::user()->departments->pluck('id');
            $rooms = Room::whereIn('department_id', $departmentIds)->get();
            return view('pages.reports.generate')->with(compact('rooms', 'terms'));
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

        $termId = $request->term;
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

        $term = Term::find($termId);
        $itemLog = ItemLog::where('mode', $status)->get();
        $isLog = !itemLog::where('mode', $status)->get()->isEmpty();
        $isStatus = !Item::where('status', $status)->get()->isEmpty();
        $rooms = Room::all();
        $currentLocation = Room::find($location);

        $room = Room::where('id', '=', $location)->get();

        foreach ($room as $index) {
            $dept_id = $index->department_id;
        }
        $department = Department::find($dept_id);

        $department = $department->department_name;

        if (Auth::user()->account_status == 'admin') {
            $items = Item::where('location', $location)->get();
            $room = Room::where('id', '=', $location)->get();

            foreach ($room as $index) {
                $dept_id = $index->department_id;
            }
            $department = Department::find($dept_id);

            $department = $department->department_name;
        } else {
            if ($status == 'Active') {
                $items = Item::where('location', $location)->whereBetween('created_at', [$term->start_date, $term->end_date])->get();
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
                    //         'itemLog',
                    //         'term'
                    //         'currentLocation',
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
                            'isStatus',
                            'currentLocation',
                            'term',
                        )
                    );
                    foreach ($rooms as $room) {
                        if ($room->id == $location)
                            return $pdf->download('InventoryReport' . $room->room_name . '.pdf');
                    }
                }

            } elseif ($status == 'For Repair' || $status == 'Obsolete') {
                $items = Item::where('location', $location)->whereBetween('updated_at', [$term->start_date, $term->end_date])->get();
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
                    //         'itemLog',
                    //         'term',
                    //         'currentLocation',
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
                            'isStatus',
                            'currentLocation',
                            'term',
                        )
                    );
                    foreach ($rooms as $room) {
                        if ($room->id == $location)
                            return $pdf->download('InventoryReport' . $room->room_name . '.pdf');
                    }
                }
            }

            if ($status == 'Missing') {
                $missingItemsLog = ItemLog::where('mode', 'Missing')->whereBetween('date', [$term->start_date, $term->end_date])->get();
                $missingItemIds = $missingItemsLog->pluck('item_id')->toArray();
                $missingItems = Item::whereIn('id', $missingItemIds)->where('location', $location)->get();
                $items = $missingItems;
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
                    //         'itemLog',
                    //         'term',
                    //         'currentLocation',
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
                    return view('pages.reports.missing')->with(
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
                            'isStatus',
                            'term',
                            'currentLocation',
                        )
                    );
                    foreach ($rooms as $room) {
                        if ($room->id == $location)
                            return $pdf->download('InventoryReport' . $room->room_name . '.pdf');
                    }
                }
            } elseif ($status == 'Transferred') {
                $currentLocation = Room::find($location);
                $transferredItemsLog = ItemLog::where('mode', 'Transferred')
                    ->where('room_from', $location)
                    ->whereBetween('date', [$term->start_date, $term->end_date])
                    ->get();
                $transferredItemIds = $transferredItemsLog->pluck('item_id')->toArray();
                $transferredItems = Item::whereIn('id', $transferredItemIds)->get();
                $items = $transferredItems;
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
                    //         'itemLog',
                    //         'term'.
                    //         'currentLocation',
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
                    return view('pages.reports.transferred')->with(
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
                            'currentLocation',
                            'role_1',
                            'role_2',
                            'role_3',
                            'role_4',
                            'isLog',
                            'isStatus',
                            'term',
                        )
                    );
                    foreach ($rooms as $room) {
                        if ($room->id == $location)
                            return $pdf->download('InventoryReport' . $room->room_name . '.pdf');
                    }
                }
            } elseif ($status == 'Replacement') {
                $replacementItems = Item::whereNotNull('replaced_item')
                    ->where('location', $location)
                    ->whereBetween('created_at', [$term->start_date, $term->end_date])
                    ->get();

                $items = $replacementItems;

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
                    //         'itemLog',
                    //         'term',
                    //         'currentLocation',
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
                    return view('pages.reports.replacement')->with(
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
                            'isStatus',
                            'term',
                            'currentLocation',
                        )
                    );
                    foreach ($rooms as $room) {
                        if ($room->id == $location)
                            return $pdf->download('InventoryReport' . $room->room_name . '.pdf');
                    }
                }
            }
        }
    }
}
