<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\Brand;
use App\Models\Order;
use App\Models\College;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ItemsController extends Controller
{
    public function index()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $items = Item::all();

            return view('pages.admin.listOfItems')->with(compact('items'));
        }
         else {           
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            $items = Item::whereIn('location', $rooms->pluck('id'))->get();          
            return view('pages.admin.listOfItems')->with('items', $items);
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
    {   if (Auth::user()->account_type == 'admin') {
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
        dd($id);
        $item = Item::find($id);
        $item->brand = $request->brand;
        $item->model = $request->model;
        $item->serial_number = $request->serial_number;
        $item->location = $request->location;
        $item->description = $request->description;
        $item->aquisition_date = $request->aquisition_date;
        $item->unit_number = $request->unit_number;
        $item->quantity = $request->quantity;
        $item->status = $request->status;
        $item->inventory_tag = $request->inventory_tag;
        $item->update();

        Session::flash('success', 'Item ' . $id . ' has been updated.');
        return redirect('list-of-items');
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
            'serial_number.*' => 'required',
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
                'unit_number' => $request->unit_number,
                'inventory_tag' => $request->inventory_tag,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'borrowed' => 'no',
            ]);
        }

        Session::flash('success', 'New Item Successfully Added. Do you want to add another one?');
        return redirect('/adding-new-item');

        // } elseif ($item == null) {

        //     Item::create([
        //         'serial_number' => $request->serial_number,
        //         'location' => $request->location,
        //         'item_category' => $request->item_category,
        //         'brand' => $request->brand,
        //         'model' => $request->model,
        //         'description' => $request->item_description,
        //         'aquisition_date' => $request->aquisition_date,
        //         'unit_number' => $request->unit_number,
        //         'inventory_tag' => $request->inventory_tag,
        //         'quantity' => $request->quantity,
        //         'status' => $request->status,
        //         'borrowed' => 'no',
        //     ]);
        //     Session::flash('success', 'New Item Successfully Added. Do you want to add another one?');
        //     return redirect('/adding-new-item');

        // } else {
        //     Session::flash('message', 'Serial number has already been registered.');
        //     return redirect('/adding-new-item');
        // }
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
                'lab_oic' => 'required',
                'it_specialist' => 'required',
                'position_1' => 'required',
                'position_2' => 'required',
                'position_3' => 'required',
                'position_4' => 'required'
            ]
        );

        $location = $request->location;
        $prepared_by = $request->prepared_by;
        $verified_by = $request->verified_by;
        $lab_oic = $request->lab_oic;
        $it_specialist = $request->it_specialist;
        $position_1 = $request->position_1;
        $position_2 = $request->position_2;
        $position_3 = $request->position_3;
        $position_4 = $request->position_4;

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
                // 'purpose',
                'location',
                'prepared_by',
                'verified_by',
                'lab_oic',
                'it_specialist',
                'department',
                'rooms',
                'position_1',
                'position_2',
                'position_3',
                'position_4'
            ))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4');
            // return view('pages.pdfReport')->with(compact(
            //     'items',
            //     // 'purpose',
            //     'location',
            //     'prepared_by',
            //     'verified_by',
            //     'lab_oic',
            //     'it_specialist',
            //     'department',
            //     'rooms'
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
        $brand = Item::distinct()->pluck('brand')->toArray();
        return response()->json($brand);
    }

    public function getModel()
    {
        $model = Item::distinct()->pluck('model')->toArray();
        return response()->json($model);
    }

    public function getUnitNumber()
    {
        $unit_number = Item::distinct()->pluck('unit_number')->toArray();
        return response()->json($unit_number);
    }
}
