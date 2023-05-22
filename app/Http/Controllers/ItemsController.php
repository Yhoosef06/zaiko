<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\Brand;
use App\Models\Order;
use App\Models\College;
use App\Models\Department;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ItemsController extends Controller
{
    public function index()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $items = Item::all()->groupBy(['brand', 'model', 'item_category']);
            // dd($items);
            return view('pages.admin.listOfItems')->with(compact('items'));
        } else {
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            $items = Item::whereIn('location', $rooms->pluck('id'))->get();
            return view('pages.admin.listOfItems')->with('items', $items);
        }
    }

    public function viewItemDetails($id)
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $item = Item::find($id);
            $rooms = Room::all();
            $room = $item->room->room_name;
            $item['room'] = $room;
            $model = $item->model;
            $items = Item::where('model', '=', $model)->get();
            $itemCategories = ItemCategory::all();
            return view('pages.admin.viewItemDetails')->with(compact('items', 'rooms', 'itemCategories'));
        } else {
            $item = Item::find($id);
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            $room = $item->room->room_name;
            $item['room'] = $room;
            $model = $item->model;
            $items = Item::where('model', '=', $model)->get();
            $itemCategories = ItemCategory::all();
            return view('pages.admin.viewItemDetails')->with(compact('items', 'rooms', 'itemCategories'));
        }
    }

    public function getItemDetails($id)
    {
        $item = Item::find($id);
        $room = $item->room->room_name;
        $item['room'] = $room;

        return response()->json($item);
    }

    public function editItemPage($id)
    {   
        if (Auth::user()->account_type == 'admin') {
            $item = Item::find($id);
            $rooms = Room::all();
            $itemCategories = ItemCategory::all();
            return view('pages.admin.editItem')->with(compact('item', 'rooms', 'itemCategories'));
        } else {
            $item = Item::find($id);
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            $itemCategories = ItemCategory::all();
            return view('pages.admin.editItem')->with(compact('item', 'rooms', 'itemCategories'));
        }
    }

    public function saveEditedItemDetails(Request $request, $id)
    {
        $item = Item::find($id);
        $item->brand = $request->brand;
        $item->model = $request->model;
        $item->serial_number = $request->serial_number;
        $item->location = $request->location;
        $item->item_category = $request->item_category;
        $item->description = $request->description;
        $item->aquisition_date = $request->aquisition_date;
        $item->quantity = $request->quantity;
        $item->status = $request->status;
        $item->inventory_tag = $request->inventory_tag;
        $item->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Changes saved successfully',
            ]);
        } else {
            Session::flash('success', 'Changes saved successfully.');
            return redirect('list-of-items');
        }
    }

    public function deleteItem($id)
    {
        $item = Item::find($id);
        $item->delete();
        Session::flash('success', 'Successfully Removed Item');
        return redirect('list-of-items');
    }

    public function saveNewItem(Request $request)
    {
        $this->validate($request, [
            'location' => 'required',
            'serial_numbers' => 'required|array|min:1',
            'serial_numbers.*' => function ($value, $fail) use ($request) {
                if (empty($value)) {
                    $fail('Serial Number field cannot be empty');
                } elseif (!$request->checkbox && count(array_keys($request->serial_numbers, $value)) > 1) {
                    $fail('Serial Numbers cannot be repeated');
                }
            },
            // 'brand' => 'required',
            // 'model' => 'required',
            'item_category' => 'required',
            'item_description' => 'required',
            'aquisition_date' => 'nullable',
            // 'unit_number' => 'required',
            'inventory_tag' => 'required',
            'quantity' => 'required|numeric',
            'status' => 'required',
        ]);

        // $item = Item::where('serial_number', '=', $request->input('serial_number'))->first();
        // if ($item == 'N/A') {
        $serial_numbers = $request->serial_numbers;
        foreach ($serial_numbers as $serial_number) {
            Item::create([
                'serial_number' => $serial_number,
                'location' => $request->location,
                'item_category' => $request->item_category,
                'brand' => $request->brand,
                'model' => $request->model,
                'description' => $request->item_description,
                'aquisition_date' => $request->aquisition_date,
                // 'unit_number' => $request->unit_number,
                'inventory_tag' => $request->inventory_tag,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'borrowed' => 'no',
            ]);
        }

        Session::flash('success', 'New Item Successfully Added. Do you want to add another one?');
        return redirect('/adding-new-item');
    }

    public function generateReportPage()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $rooms = Room::all();
            return view('pages.admin.report')->with(compact('rooms'));
        } else {
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            return view('pages.admin.report')->with(compact('rooms'));
        }
    }

    public function generateReturned()
    {
        $data = Order::where('order_status', '=', 'returned')->get();
        return view('pages.admin.returnedItems')->with(compact('data'));
    }

    public function reportTest()
    {

        $borrows = Order::where('order_status', '=', 'returned')->get();
        return view('pages.pdfReturnedItems')->with(compact('borrows'));
    }

    public function downloadReturnedReport(Request $request)
    {
        // $items = Order::orderBy('id_number', 'ASC')->get();
        $items = Order::where('order_status', '=', 'returned')->orderBy('id_number', 'ASC')->get();

        if ($request->has('download')) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pages.pdfReturnedItems', compact(
                'items'
            ))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4');

            return $pdf->download('ReturnedItemsReport' . '.pdf');
        }

        return view('pages.pdfReturnedItems')->with(compact(
            'first_name',
            'items'
        ));
    }

    public function downloadBorrowedReport(Request $request)
    {
        // $items = Order::orderBy('id_number', 'ASC')->get();
        $items = Order::where('order_status', '=', 'borrowed')->orderBy('id_number', 'ASC')->get();

        if ($request->has('download')) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pages.pdfBorrowedItems', compact(
                'items'
            ))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4');

            return $pdf->download('BorrowedItemsReport' . '.pdf');
        }

        return view('pages.pdfBorrowedItems')->with(compact(
            'first_name',
            'items'
        ));
    }


    public function downloadReport(Request $request)
    {
        $this->validate(
            $request,
            [
                'location' => 'required',
                // 'purpose' => 'nullable',
                // 'department' => 'required',
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
        $prepared_by = $request->prepared_by;
        $verified_by = $request->verified_by;
        $noted_by = $request->noted_by;
        $approved_by = $request->approved_by;
        $role_1 = $request->role_1;
        $role_2 = $request->role_2;
        $role_3 = $request->role_3;
        $role_4 = $request->role_4;

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

            $items = Item::where('location', $location)->get();
            $room = Room::where('id', '=', $location)->get();

            foreach ($room as $index) {
                $dept_id = $index->department_id;
            }
            $department = Department::find($dept_id);

            $department = $department->department_name;
        }


        if ($request->has('download')) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pages.pdfReport', compact(
                'items',
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
                'role_4'
            ))->setOptions(['defaultFont' => 'sans-serif',])->setPaper('a4');
            // return view('pages.pdfReport')->with(compact(
            //     'items',
            //     'location',
            //     'prepared_by',
            //     'verified_by',
            //     'lab_oic',
            //     'it_specialist',
            //     'department',
            //     'rooms',
            //     'position_1',
            //     'position_2',
            //     'position_3',
            //     'position_4'
            // ));
            foreach ($rooms as $room) {
                if ($room->id == $location)
                    return $pdf->download('InventoryReport' . $room->room_name . '.pdf');
            }
        }
    }


    // public function searchItem(Request $request)
    // {
    //     $search_text = request('query');

    //     $items = Item::where('item_name', 'LIKE', '%' . $search_text . '%')
    //         ->orWhere('location', 'LIKE', '%' . $search_text . '%')
    //         ->orWhere('item_description', 'LIKE', '%' . $search_text . '%')
    //         ->orWhere('serial_number', 'LIKE', '%' . $search_text . '%')->orderBy('location', 'desc')->paginate(5);

    //     // dd($items);
    //     return view('pages.admin.listOfItems', compact('items'));
    // }

    public function getBrand()
    {
        $brands  = Item::distinct()->pluck('brand')->reject(function ($brand) {
            return $brand === null;
        })->toArray();

        return response()->json($brands);
    }

    public function getModel()
    {
        $models = Item::distinct()->pluck('model')->reject(function ($model) {
            return $model === null;
        })->toArray();

        return response()->json($models);
    }

    public function getUnitNumber()
    {
        $unit_numbers = Item::distinct()->pluck('unit_number')->reject(function ($unit_number) {
            return $unit_number === null;
        })->toArray();

        return response()->json($unit_numbers);
    }
}
