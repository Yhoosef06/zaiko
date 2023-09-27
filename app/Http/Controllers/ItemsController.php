<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Models;
use App\Models\College;
use App\Models\ItemLog;
use App\Models\OrderItem;
use App\Models\Reference;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use App\Models\OrderItemTemp;
use App\Rules\ExistsInDatabase;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Database\Seeders\OrderItemTempSeeder;
use Illuminate\Support\Facades\Validator;


class ItemsController extends Controller
{
    public function index()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $items = Item::all();
            // dd($items);
            return view('pages.admin.listOfItems')->with(compact('items'));
        } else {
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            // $items = Item::whereIn('location', $rooms->pluck('id'))->get()->groupBy(['brand', 'model', 'item_category']);
            $items = Item::whereIn('location', $rooms->pluck('id'))->get();
            return view('pages.admin.listOfItems')->with('items', $items);
        }
    }
    // dd($itemLogs);
    public function viewItemDetails($id)
    {
        $item = Item::find($id);
        $itemLogs = ItemLog::where('item_id', '=', $id)->get();

        return view('pages.admin.viewItemDetails')->with(compact('item', 'itemLogs'));
    }

    public function addItem()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $rooms = Room::all();
            $brands = Brand::all()->sortBy('brand_name');
            $models = Models::all();
            $itemCategories = ItemCategory::all();
            $departments = Department::with('college')->get();
            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });
            $colleges = College::with('departments')->orderBy('college_name')->get();
            return view('pages.admin.addItem')->with(compact('rooms', 'itemCategories', 'departments', 'colleges', 'brands', 'models'));
        } else {
            $user_dept_id = Auth::user()->department_id;
            $rooms = Room::where('department_id', $user_dept_id)->get();
            $brands = Brand::all()->sortBy('brand_name');
            $models = Models::all();
            $itemCategories = ItemCategory::all();
            return view('pages.admin.addItem')->with(compact('rooms', 'itemCategories', 'brands', 'models'));
        }
    }

    public function getItemDetails($id)
    {
        $item = Item::find($id);
        $room = $item->room->room_name;
        $category = $item->category->category_name;
        $item['room'] = $room;
        $item['category'] = $category;
        return response()->json($item);
    }

    public function editItemPage($id)
    {
        $user = Auth::user();
        $isAdmin = $user->account_type == 'admin';
        $item = Item::find($id);
        $brands = Brand::all();
        $models = Models::all();
        $rooms = $isAdmin ? Room::all() : Room::where('department_id', $user->department_id)->get();
        $itemCategories = ItemCategory::all();
        $category = $item->category ? $item->category->category_name : null;

        return view('pages.admin.editItem')->with(compact('item', 'rooms', 'itemCategories', 'category', 'brands', 'models'));
    }

    public function saveEditedItemDetails(Request $request, $id)
    {
        $item = Item::find($id);
        $randomString = Str::random(10);
        $itemImage = $request->file('item_image');
        $imagePath = null;
        if ($itemImage == null) {
            $imagePath = $item->item_image;
        } else {
            $imagePath = $itemImage->storeAs(
                'Item Images',
                $randomString . '.' . $itemImage->getClientOriginalExtension(),
                'public'
            );
        }

        $item->brand_id = $request->brand;
        $item->model_id = $request->model;
        $item->serial_number = $request->serial_number;
        $item->location = $request->location;
        $item->category_id = $request->item_category;
        $item->description = $request->description;
        $item->aquisition_date = $request->aquisition_date;
        $item->quantity = $request->quantity;
        $item->status = $request->status;
        $item->duration = $request->duration;
        $item->duration_type = $request->duration_type;
        $item->part_number  = $request->part_number;
        $item->inventory_tag = $request->inventory_tag;
        $item->item_image = $imagePath;
        $item->save();

        $itemLog = new ItemLog();
        $itemLog->item_id = $item->id;
        $itemLog->quantity = $item->quantity;
        $itemLog->encoded_by = Auth::user()->id_number;
        $itemLog->mode = 'edited item details';
        $itemLog->date = now();
        $itemLog->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Changes saved successfully',
            ]);
        } else {
            Session::flash('success', 'Changes for item # ' . $item->id . ' saved successfully.');
            return redirect('list-of-items');
        }
    }

    public function deleteItem($id)
    {
        try {
            $item = Item::find($id);

            // Check if the item is currently borrowed
            if ($item->borrowed == 'yes') {
                Session::flash('danger', 'Warning: Unable to remove item that is currently being borrowed.');
                return  redirect('list-of-items');
            }

            // Delete the item
            $item->delete();

            Session::flash('success', 'Successfully Removed Item');
            return redirect('list-of-items');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot delete item because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }

            return redirect('list-of-items');
        }
    }

    // public function saveNewItem(Request $request)
    // {
    //     $serial_numbers = $request->serial_number;
    //     $quantity = $request->has('quantity_checkbox') ? 1 : $request->input('quantity');
    //     $randomString = Str::random(10);
    //     $itemImage = $request->file('item_image');
    //     $imagePath = null;
    //     $invalidSerialNumbers = [];
    //     $validSerialNumbers = [];

    //     if ($itemImage) {
    //         $imagePath = $itemImage->storeAs(
    //             'Item Images',
    //             $randomString . '.' . $itemImage->getClientOriginalExtension(),
    //             'public'
    //         );
    //     }

    //     $this->validate($request, [
    //         'location' => 'required',
    //         'item_category' => 'required',
    //         'item_description' => 'required',
    //         'aquisition_date' => 'required',
    //         'inventory_tag' => 'required',
    //         'quantity' => 'required|numeric|min:1',
    //         'status' => 'required',
    //     ]);

    //     if ($serial_numbers !== null) {

    //         foreach ($serial_numbers as $serial_number) {

    //             $validator = Validator::make(['serial_number' => $serial_number], [
    //                 'serial_number' => ['unique:items,serial_number', 'regex:/^[a-zA-Z0-9]*$/'],
    //             ]);

    //             if ($validator->fails()) {
    //                 $invalidSerialNumbers[] = $serial_number;
    //             } else {
    //                 $validSerialNumbers[] = $serial_number;
    //             }
    //         }

    //         foreach ($validSerialNumbers as $validSerialNumber) {
    //             $item = Item::create([
    //                 'serial_number' => $validSerialNumber ? $validSerialNumber : 'N/A',
    //                 'location' => $request->location,
    //                 'category_id' => $request->item_category,
    //                 'brand_id' => $request->brand ? $request->brand : 1,
    //                 'model_id' => $request->model ? $request->model : 1,
    //                 'part_number' => $request->part_number ? $request->part_number : 'N/A',
    //                 'description' => $request->item_description,
    //                 'aquisition_date' => $request->aquisition_date,
    //                 'inventory_tag' => $request->inventory_tag,
    //                 'quantity' => $quantity,
    //                 'status' => $request->status,
    //                 'duration_type' => $request->duration_type,
    //                 'duration' => $request->duration,
    //                 'borrowed' => 'no',
    //                 'item_image' =>  $imagePath,
    //             ]);

    //             $itemLog = new ItemLog();
    //             $itemLog->item_id = $item->id;
    //             $itemLog->quantity = $item->quantity;
    //             $itemLog->encoded_by = Auth::user()->id_number;
    //             $itemLog->mode = 'added';
    //             $itemLog->date = now();
    //             $itemLog->save();
    //         }

    //         if (!empty($invalidSerialNumbers) && empty($validSerialNumbers)) {
    //             session()->put('invalidSerialNumbers', $invalidSerialNumbers);
    //             return redirect('/adding-new-item')->with('error', 'Failed to add item(s) due to invalid serial numbers. Please check the following serial numbers: ');
    //         } elseif (!empty($invalidSerialNumbers) && !empty($validSerialNumbers)) {
    //             session()->put('invalidSerialNumbers', $invalidSerialNumbers);
    //             return redirect('/adding-new-item')->with('warning', 'Item(s) added successfully, but some serial numbers are invalid. Please check the following serial numbers: ');
    //         } else {
    //             Session::flash('success', 'Item(s) added successfully. Do you want to add another one?');
    //             return redirect('/adding-new-item');
    //         }
    //     } else {
    //         $item = Item::create([
    //             'serial_number' => 'N/A',
    //             'location' => $request->location,
    //             'category_id' => $request->item_category,
    //             'brand_id' => $request->brand ? $request->brand : 1,
    //             'model_id' => $request->model ? $request->model : 1,
    //             'part_number' => $request->part_number ? $request->part_number : 'N/A',
    //             'description' => $request->item_description,
    //             'aquisition_date' => $request->aquisition_date,
    //             'inventory_tag' => $request->inventory_tag,
    //             'quantity' => $quantity,
    //             'status' => $request->status,
    //             'duration_type' => $request->duration_type,
    //             'duration' => $request->duration,
    //             'borrowed' => 'no',
    //             'item_image' =>  $imagePath,
    //         ]);

    //         $itemLog = new ItemLog();
    //         $itemLog->item_id = $item->id;
    //         $itemLog->quantity = $item->quantity;
    //         $itemLog->encoded_by = Auth::user()->id_number;
    //         $itemLog->mode = 'added';
    //         $itemLog->date = now();
    //         $itemLog->save();
    //     }

    //     Session::flash('success', 'Item(s) added successfully. Do you want to add another one?');
    //     return redirect('/adding-new-item');
    // }

    public function saveNewItem(Request $request)
    {
        $serial_numbers = $request->serial_number;
        $quantity = $request->has('quantity_checkbox') ? 1 : $request->input('quantity');
        $randomString = Str::random(10);
        $itemImage = $request->file('item_image');
        $imagePath = null;
       
        if ($request->input('location') == null) {
            return response()->json(['emptyLocation' => 'Please select a room/location.']);
        }
     
        if ($request->input('item_category') == null) {
            return response()->json(['emptyCategory' => 'Please select a category for the item.']);
        }
      
        if ($itemImage) {
            $imagePath = $itemImage->storeAs(
                'Item Images',
                $randomString . '.' . $itemImage->getClientOriginalExtension(),
                'public'
            );
        }
    
        $this->validate($request, [
            'location' => 'required',
            'item_category' => 'required',
            'item_description' => 'required',
            'aquisition_date' => 'required',
            'inventory_tag' => 'required',
            'quantity' => 'required|numeric|min:1',
            'status' => 'required',
        ]);

        if ($serial_numbers != null) {

            if ($this->hasDuplicateSerialNumbers($serial_numbers)) {
                return response()->json(['duplicate' => 'Duplicate serial number(s) detected. Please review your entries']);
            }

            foreach ($serial_numbers as $serial_number) {
                $validator = Validator::make(['serial_number' => $serial_number], [
                    'serial_number' => ['unique:items,serial_number', 'regex:/^[a-zA-Z0-9]*$/'],
                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => 'Serial number(s) already exists in the database']);
                }
                $item = Item::create([
                    'serial_number' => $serial_number ? $serial_number : 'N/A',
                    'location' => $request->location,
                    'category_id' => $request->item_category,
                    'brand_id' => $request->brand ? $request->brand : 1,
                    'model_id' => $request->model ? $request->model : 1,
                    'part_number' => $request->part_number ? $request->part_number : 'N/A',
                    'description' => $request->item_description,
                    'aquisition_date' => $request->aquisition_date,
                    'inventory_tag' => $request->inventory_tag,
                    'quantity' => $quantity,
                    'status' => $request->status,
                    'duration_type' => $request->duration_type,
                    'duration' => $request->duration,
                    'borrowed' => 'no',
                    'item_image' =>  $imagePath,
                ]);

                $itemLog = new ItemLog();
                $itemLog->item_id = $item->id;
                $itemLog->quantity = $item->quantity;
                $itemLog->encoded_by = Auth::user()->id_number;
                $itemLog->mode = 'added';
                $itemLog->date = now();
                $itemLog->save();
            }
            // if (!empty($invalidSerialNumbers) && empty($validSerialNumbers)) {
            //     session()->put('invalidSerialNumbers', $invalidSerialNumbers);
            // Session::flash('error', 'The following serial number(s) are already found the database: ');
            // return response()->json(['error' => 'Serial number already exists in the database']);
            // return redirect('/adding-new-item')->with('error', 'Failed to add item(s). The following serial numbers are already taken:',);
            // } 
            // else
            // if (!empty($invalidSerialNumbers) && !empty($validSerialNumbers)) {
            //     session()->put('invalidSerialNumbers', $invalidSerialNumbers);
            //     return redirect('/adding-new-item')->with('warning', 'Item(s) added successfully, but some serial numbers are invalid. Please check the following serial numbers: ');
            // } else {
            // dd('2');
            Session::flash('success', 'Do you want to add another one?');
            return response()->json(['success' => 'Item(s) added successfully']);
            // }
        } else {
            $item = Item::create([
                'serial_number' => 'N/A',
                'location' => $request->location,
                'category_id' => $request->item_category,
                'brand_id' => $request->brand ? $request->brand : 1,
                'model_id' => $request->model ? $request->model : 1,
                'part_number' => $request->part_number ? $request->part_number : 'N/A',
                'description' => $request->item_description,
                'aquisition_date' => $request->aquisition_date,
                'inventory_tag' => $request->inventory_tag,
                'quantity' => 1,
                'status' => $request->status,
                'duration_type' => $request->duration_type,
                'duration' => $request->duration,
                'borrowed' => 'no',
                'item_image' =>  $imagePath,
            ]);

            $itemLog = new ItemLog();
            $itemLog->item_id = $item->id;
            $itemLog->quantity = $item->quantity;
            $itemLog->encoded_by = Auth::user()->id_number;
            $itemLog->mode = 'added';
            $itemLog->date = now();
            $itemLog->save();

            Session::flash('success', 'Do you want to add another one?');
            return response()->json(['success' => 'Item(s) added successfully']);
        }
    }

    private function hasDuplicateSerialNumbers($serial_numbers)
    {
        return count($serial_numbers) !== count(array_unique($serial_numbers));
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
            Reference::create([
                'location' => $request->location,
                'prepared_by' => $request->prepared_by,
                'verified_by' => $request->verified_by,
                'noted_by' => $request->noted_by,
                'approved_by' => $request->approved_by,
                'role_1' => $request->role_1,
                'role_2' => $request->role_2,
                'role_3' => $request->role_3,
                'role_4' => $request->role_4,
            ]);
            // return view('pages.pdfReport')->with(compact(
            //     'items',
            //     'location',
            //     'prepared_by',
            //     'verified_by',
            //     'noted_by',
            //     'approved_by',
            //     'department',
            //     'rooms',
            //     'role_1',
            //     'role_2',
            //     'role_3',
            //     'role_4'
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
        $brands  = Brand::distinct()->pluck('brand_name')->reject(function ($brand) {
            return $brand === null;
        })->toArray();

        return response()->json($brands);
    }

    public function getModel()
    {
        $models = Models::distinct()->pluck('model_name')->reject(function ($model) {
            return $model === null;
        })->toArray();

        return response()->json($models);
    }

    public function getPartNumber()
    {
        $part_number = Item::distinct()->pluck('part_number')->reject(function ($part_number) {
            return $part_number === null;
        })->toArray();

        return response()->json($part_number);
    }

    public function transferItem($id)
    {
        $item = Item::find($id);
        if (auth::user()->account_type == 'admin') {
            $rooms = Room::all();
        } else {
            $dept_id = auth::user()->department_id;
            $rooms = Room::where('department_id', $dept_id)->get();
        }
        return view('pages.admin.transferItem')->with(compact('item', 'rooms'));
    }

    public function saveTransferItem(Request $request, $id)
    {
        $item = Item::find($id);

        $itemLog = new ItemLog();
        $itemLog->item_id = $item->id;
        $itemLog->quantity = $item->quantity;
        $itemLog->encoded_by = Auth::user()->id_number;
        $itemLog->mode = 'transferred';
        $itemLog->room_from = $item->location;
        $itemLog->room_to = $request->room_to;
        $itemLog->date = now();
        $itemLog->save();

        $item->update([
            'location' => $request->room_to,

        ]);

        return redirect()->route('view_items')->with('success', 'Item transferred successfully');
    }

    public function addSubItem($id)
    {
        $item = Item::find($id);
        $brands = Brand::all();
        $models = Models::all();
        return view('pages.admin.addSubItem')->with(compact('item', 'brands', 'models'));
    }

    public function saveSubItem(Request $request, $id)
    {
        $parentItem = Item::find($id);

        $item = Item::create([
            'serial_number' => $request->serial_number,
            'location' => $parentItem->location,
            'category_id' => $parentItem->category_id,
            'brand_id' => $request->brand ? $request->brand : 1,
            'model_id' => $request->model ? $request->brand : 1,
            'part_number' => $request->part_number,
            'description' => $request->description,
            'aquisition_date' => $request->aquisition_date,
            'inventory_tag' => $request->inventory_tag,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'borrowed' => 'no',
            'parent_item' => $id,
            'duration' => $parentItem->duration,
            'duration_type' => $parentItem->duration_type
        ]);

        $itemLog = new ItemLog();
        $itemLog->item_id = $item->id;
        $itemLog->quantity = $item->quantity;
        $itemLog->encoded_by = Auth::user()->id_number;
        $itemLog->mode = 'added';
        $itemLog->date = now();
        $itemLog->save();

        return redirect()->route('view_items')->with('success', 'Sub Item Added Successfully');
    }

    public function replaceItem($id)
    {
        $item = Item::find($id);
        $brands = Brand::all();
        $models = Models::all();
        return view('pages.admin.replaceItem')->with(compact('item', 'models', 'brands'));
    }

    public function saveReplacedItem(Request $request, $id)
    {
        $replacedItem = Item::find($id);

        $item = Item::create([
            'serial_number' => $request->serial_number,
            'location' => $replacedItem->location,
            'category_id' => $replacedItem->category_id,
            'brand_id' => $request->brand ? $request->brand : 1,
            'model_id' => $request->model ? $request->brand : 1,
            'part_number' => $request->part_number,
            'description' => $request->description,
            'aquisition_date' => $request->aquisition_date,
            'inventory_tag' => $replacedItem->inventory_tag,
            'quantity' => $replacedItem->quantity,
            'status' => $request->status,
            'borrowed' => 'no',
            'replaced_item' => $id,
            'duration' => $replacedItem->duration,
            'duration_type' => $replacedItem->duration_type
        ]);

        $itemLog = new ItemLog();
        $itemLog->item_id = $item->id;
        $itemLog->quantity = $item->quantity;
        $itemLog->encoded_by = Auth::user()->id_number;
        $itemLog->mode = 'replacement';
        $itemLog->date = now();
        $itemLog->save();

        return redirect()->route('view_items')->with('success', 'Item # ' . $id . ' Replaced Successfully');
    }
}
