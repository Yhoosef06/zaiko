<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Role;
use App\Models\Room;
use App\Models\User;
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
use Illuminate\Support\Facades\Log;
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
        if (Auth::user()->roles->contains('name', 'admin')) {
            $role = Role::where('name', 'admin')->first();
            $sortOrder = 'asc';
            $canManageInventory = $role->permissions->contains('id', 1);
            if ($canManageInventory) {
                $items = Item::paginate(20);
                $filterItems = Item::all();
                return view('pages.admin.listOfItems')->with(compact('items', 'sortOrder', 'filterItems'));
            } else {
                return redirect('/admin-dashboard')->with('danger', 'Access have been denied.');
            }
        } else if (Auth::user()->roles->contains('name', 'manager')) {
            $role = Role::where('name', 'manager')->first();
            $sortOrder = 'asc';
            $canManageInventory = $role->permissions->contains('id', 1);
            if ($canManageInventory) {
                $userId = auth()->user()->id_number;
                $user = User::find($userId);
                $departmentIds = $user->departments->pluck('id');
                $rooms = Room::whereIn('department_id', $departmentIds)->get();
                $roomIds = $rooms->pluck('id');
                $items = Item::whereIn('location', $roomIds)->paginate(20);
                $filterItems = Item::whereIn('location', $roomIds)->get();
                return view('pages.admin.listOfItems')->with(compact('items', 'sortOrder', 'filterItems'));
            } else {
                return redirect('/admin-dashboard')->with('danger', 'Access have been denied.');
            }
        }
    }
    public function viewItemDetails($id)
    {
        $item = Item::find($id);
        $itemLogs = ItemLog::where('item_id', '=', $id)->orderBy('date', 'desc')->get();

        return view('pages.admin.viewItemDetails')->with(compact('item', 'itemLogs'));
    }

    public function addItem()
    {
        //admin
        if (Auth::user()->roles->contains('name', 'admin')) {
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
            $userId = auth()->user()->id_number;
            $user = User::find($userId);
            $departmentIds = $user->departments->pluck('id');

            $rooms = Room::whereIn('department_id', $departmentIds)->get();
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
        $departments = $user->departments;
        $isAdmin = Auth::user()->roles->contains('name', 'admin');
        $item = Item::find($id);
        $brands = Brand::all();
        $models = Models::all();
        $rooms = $isAdmin ? Room::all() : Room::whereIn('department_id', $departments->pluck('id'))->get();
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

        $item->brand_id = $request->brand ? $request->brand : 1;
        $item->model_id = $request->model ? $request->model : 1;
        $item->serial_number = $request->serial_number;
        $item->location = $request->location;
        $item->category_id = $request->item_category;
        $item->description = $request->description;
        $item->aquisition_date = $request->aquisition_date;
        $item->quantity = $request->quantity;
        $item->status = $request->status;
        $item->duration = $request->duration;
        $item->penalty_fee = $request->penalty_fee;
        $item->duration_type = $request->duration_type;
        $item->part_number = $request->part_number;
        $item->inventory_tag = $request->inventory_tag;
        $item->item_image = $imagePath;
        $item->save();

        $itemLog = new ItemLog();
        $itemLog->item_id = $item->id;
        $itemLog->quantity = $item->quantity;
        $itemLog->encoded_by = Auth::user()->id_number;
        $itemLog->mode = 'edited';
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
                return redirect('list-of-items');
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
            'penalty_fee' => 'required'
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
                    'penalty_fee' => $request->penalty_fee,
                    'quantity' => 1,
                    'status' => $request->status,
                    'duration_type' => $request->duration_type,
                    'duration' => $request->duration,
                    'borrowed' => 'no',
                    'item_image' => $imagePath,
                ]);

                $itemLog = new ItemLog();
                $itemLog->item_id = $item->id;
                $itemLog->quantity = $item->quantity;
                $itemLog->encoded_by = Auth::user()->id_number;
                $itemLog->mode = 'added';
                $itemLog->date = now();
                $itemLog->save();
            }

            Session::flash('success', 'Do you want to add another one?');
            return response()->json(['success' => 'Item(s) added successfully']);

        } else {
            $existingItem = Item::where('part_number', $request->part_number)
                ->where('location', $request->location)
                ->first();

            if ($existingItem) {
                $existingItem->quantity += $quantity;
                $existingItem->save();

                $itemLog = new ItemLog();
                $itemLog->item_id = $existingItem->id;
                $itemLog->quantity = $quantity;
                $itemLog->encoded_by = Auth::user()->id_number;
                $itemLog->mode = 'quantity_updated';
                $itemLog->date = now();
                $itemLog->save();
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
                    'quantity' => $quantity,
                    'status' => $request->status,
                    'duration_type' => $request->duration_type,
                    'duration' => $request->duration,
                    'borrowed' => 'no',
                    'item_image' => $imagePath,
                ]);

                $itemLog = new ItemLog();
                $itemLog->item_id = $item->id;
                $itemLog->quantity = $item->quantity;
                $itemLog->encoded_by = Auth::user()->id_number;
                $itemLog->mode = 'added';
                $itemLog->date = now();
                $itemLog->save();
            }

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
        if (Auth::user()->roles->contains('name', 'admin')) {
            $rooms = Room::all();
            return view('pages.admin.report')->with(compact('rooms'));
        } else {
            $departmentIds = Auth::user()->departments->pluck('id');
            $rooms = Room::whereIn('department_id', $departmentIds)->get();
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
            $pdf->loadView(
                'pages.pdfReturnedItems',
                compact(
                    'items'
                )
            )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4');

            return $pdf->download('ReturnedItemsReport' . '.pdf');
        }

        return view('pages.pdfReturnedItems')->with(
            compact(
                'first_name',
                'items'
            )
        );
    }

    public function downloadBorrowedReport(Request $request)
    {
        // $items = Order::orderBy('id_number', 'ASC')->get();
        $items = Order::where('order_status', '=', 'borrowed')->orderBy('id_number', 'ASC')->get();

        if ($request->has('download')) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView(
                'pages.pdfBorrowedItems',
                compact(
                    'items'
                )
            )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4');

            return $pdf->download('BorrowedItemsReport' . '.pdf');
        }

        return view('pages.pdfBorrowedItems')->with(
            compact(
                'first_name',
                'items'
            )
        );
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
            $pdf->loadView(
                'pages.pdfReport',
                compact(
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
                )
            )->setOptions(['defaultFont' => 'sans-serif',])->setPaper('a4');
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


    public function searchItem(Request $request)
    {
        $search_text = $request->input('search');
        $sortOrder = 'asc';

        if (Auth::user()->roles->contains('name', 'admin')) {
            $filterItems = Item::all();
            $items = Item::with('brand', 'model', 'category', 'room')
                ->where(function ($query) use ($search_text) {
                    $query->where('description', 'LIKE', '%' . $search_text . '%')
                        ->orWhere('serial_number', 'LIKE', '%' . $search_text . '%')
                        ->orWhere('part_number', 'LIKE', '%' . $search_text . '%')
                        ->orWhereHas('brand', function ($query) use ($search_text) {
                            $query->where('brand_name', 'LIKE', '%' . $search_text . '%');
                        })
                        ->orWhereHas('model', function ($query) use ($search_text) {
                            $query->where('model_name', 'LIKE', '%' . $search_text . '%');
                        })
                        ->orWhereHas('category', function ($query) use ($search_text) {
                            $query->where('category_name', 'LIKE', '%' . $search_text . '%');
                        })
                        ->orWhereHas('room', function ($query) use ($search_text) {
                            $query->where('room_name', 'LIKE', '%' . $search_text . '%');
                        });
                })
                ->paginate(20);
        } else {
            $userId = auth()->user()->id_number;
            $user = User::find($userId);
            $departmentIds = $user->departments->pluck('id');
            $rooms = Room::whereIn('department_id', $departmentIds)->get();
            $roomIds = $rooms->pluck('id');
            $items = Item::whereIn('location', $roomIds)->with('brand', 'model', 'category', 'room')
                ->where(function ($query) use ($search_text) {
                    $query->where('description', 'LIKE', '%' . $search_text . '%')
                        ->orWhere('serial_number', 'LIKE', '%' . $search_text . '%')
                        ->orWhere('part_number', 'LIKE', '%' . $search_text . '%')
                        ->orWhereHas('brand', function ($query) use ($search_text) {
                            $query->where('brand_name', 'LIKE', '%' . $search_text . '%');
                        })
                        ->orWhereHas('model', function ($query) use ($search_text) {
                            $query->where('model_name', 'LIKE', '%' . $search_text . '%');
                        })
                        ->orWhereHas('category', function ($query) use ($search_text) {
                            $query->where('category_name', 'LIKE', '%' . $search_text . '%');
                        })
                        ->orWhereHas('room', function ($query) use ($search_text) {
                            $query->where('room_name', 'LIKE', '%' . $search_text . '%');
                        });
                })
                ->paginate(20);
            $filterItems = Item::whereIn('location', $roomIds)->get();
        }

        return view('pages.admin.listOfItems', compact('items', 'sortOrder', 'filterItems'));
    }

    public function sortItems($order)
    {
        $sortOrder = $order;
        if (Auth::user()->roles->contains('name', 'admin')) {
            $items = Item::orderBy('id', $order)->paginate(20);
            $filterItems = Item::all();
        } else {
            $userId = auth()->user()->id_number;
            $user = User::find($userId);
            $departmentIds = $user->departments->pluck('id');
            $rooms = Room::whereIn('department_id', $departmentIds)->get();
            $roomIds = $rooms->pluck('id');
            $filterItems = Item::whereIn('location', $roomIds)->get();
            $items = item::whereIn('location', $roomIds)->orderBy('id', $order)->paginate(20);
        }
        return view('pages.admin.listOfItems')->with(compact('items', 'sortOrder', 'filterItems'));
    }

    public function getFilteredItems(Request $request)
    {
        $brandIds = $request->input('brand_ids', []);
        $modelIds = $request->input('model_ids', []);
        $categoryIds = $request->input('category_ids', []);
        $roomIds = $request->input('room_ids', []);
        $sortOrder = 'asc';

        // Use the retrieved filter parameters to query the items
        $filteredItems = Item::query();

        if (!empty($brandIds)) {
            $filteredItems->whereIn('brand_id', $brandIds);
        }

        if (!empty($modelIds)) {
            $filteredItems->whereIn('model_id', $modelIds);
        }

        if (!empty($categoryIds)) {
            $filteredItems->whereIn('category_id', $categoryIds);
        }

        if (!empty($roomIds)) {
            $filteredItems->whereIn('location', $roomIds);
        }

        $items = $filteredItems->paginate(20);

        if (Auth::user()->roles->contains('name', 'admin')) {
            $filterItems = Item::all();
        } else {
            $userId = auth()->user()->id_number;
            $user = User::find($userId);
            $departmentIds = $user->departments->pluck('id');
            $rooms = Room::whereIn('department_id', $departmentIds)->get();
            $roomIds = $rooms->pluck('id');
            $filterItems = Item::whereIn('location', $roomIds)->get();
        }
        return view('pages.admin.listOfItems', compact('items', 'sortOrder', 'filterItems'));
    }

    public function getBrand()
    {
        $brands = Brand::distinct()->pluck('brand_name')->reject(function ($brand) {
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
        $user = Auth::user();
        $departmentIds = [];

        if ($user->departments()->exists()) {
            $departmentIds = $user->departments()->pluck('departments.id')->toArray();
        }
        try {
            if ($user->hasRole('admin')) {
                $rooms = Room::all();
            } elseif ($user->hasRole('manager')) {
                $rooms = Room::whereIn('department_id', $departmentIds)->get();
            }
        } catch (\Throwable $th) {
            dd($th);
        }

        return view('pages.admin.transferItem', compact('item', 'rooms'));
    }

    // public function saveTransferItem(Request $request, $id)
    // {
    //     $item = Item::find($id);
    //     $quantity = $request->quantity !== null && $request->quantity !== '' ? $request->quantity : $item->quantity;

    //     $itemLog = new ItemLog();
    //     $itemLog->item_id = $item->id;
    //     $itemLog->quantity = $quantity; // Log the transferred quantity
    //     $itemLog->encoded_by = Auth::user()->id_number;
    //     $itemLog->mode = 'transferred';
    //     $itemLog->room_from = $item->location;
    //     $itemLog->room_to = $request->room_to;
    //     $itemLog->date = now();
    //     $itemLog->save();

    //     if ($quantity) {
    //         $existingItemTo = Item::where('serial_number', $item->serial_number)
    //             ->where('location', $request->room_to)
    //             ->where('part_number', $item->part_number)
    //             ->first();

    //         if ($existingItemTo) {
    //             $existingItemTo->update([
    //                 'quantity' => $existingItemTo->quantity + $quantity, // Add the transferred quantity
    //             ]);
    //         } else {
    //             $newItem = Item::create([
    //                 'serial_number' => $item->serial_number ? $item->serial_number : 'N/A',
    //                 'location' => $request->room_to,
    //                 'category_id' => $item->category_id,
    //                 'brand_id' => $item->brand_id ? $item->brand_id : 1,
    //                 'model_id' => $item->model_id ? $item->model_id : 1,
    //                 'part_number' => $item->part_number ? $item->part_number : 'N/A',
    //                 'description' => $item->description,
    //                 'aquisition_date' => $item->aquisition_date,
    //                 'inventory_tag' => $item->inventory_tag,
    //                 'penalty_fee' => $item->penalty_fee,
    //                 'quantity' => $quantity,
    //                 'status' => $item->status,
    //                 'duration_type' => $item->duration_type,
    //                 'duration' => $item->duration,
    //                 'borrowed' => 'no',
    //                 'item_image' => $item->item_image,
    //             ]);
    //         }

    //         $item->update([
    //             'quantity' => $item->quantity - $quantity, // Deduct transferred quantity from original item
    //         ]);

    //         // If transferred back to the original room, add the quantity back to the original item
    //         if ($request->room_to === $item->location) {
    //             if ($existingItemTo) {
    //                 $existingItemTo->update([
    //                     'quantity' => $existingItemTo->quantity - $quantity, // Deduct the transferred quantity
    //                 ]);
    //             }
    //         }
    //     } else {
    //         $item->update([
    //             'location' => $request->room_to,
    //         ]);
    //     }
    //     return back()->with('success', 'Item #' . $id . ' transferred successfully.');
    // }

    public function saveTransferItem(Request $request, $id)
    {
        $item = Item::find($id);
        $quantity = $request->quantity !== null && $request->quantity !== '' ? $request->quantity : $item->quantity;

        $itemLog = new ItemLog();
        $itemLog->item_id = $item->id;
        $itemLog->quantity = $quantity; // Log the transferred quantity
        $itemLog->encoded_by = Auth::user()->id_number;
        $itemLog->mode = 'transferred';
        $itemLog->room_from = $item->location;
        $itemLog->room_to = $request->room_to;
        $itemLog->date = now();
        $itemLog->save();

        if ($quantity) {
            $existingItemTo = Item::where('serial_number', $item->serial_number)
                ->where('location', $request->room_to)
                ->where('part_number', $item->part_number)
                ->first();

            if ($existingItemTo) {
                $existingItemTo->update([
                    'quantity' => $existingItemTo->quantity + $quantity, // Add the transferred quantity
                ]);
            } else {
                $newItem = Item::create([
                    'serial_number' => $item->serial_number ? $item->serial_number : 'N/A',
                    'location' => $request->room_to,
                    'category_id' => $item->category_id,
                    'brand_id' => $item->brand_id ? $item->brand_id : 1,
                    'model_id' => $item->model_id ? $item->model_id : 1,
                    'part_number' => $item->part_number ? $item->part_number : 'N/A',
                    'description' => $item->description,
                    'aquisition_date' => $item->aquisition_date,
                    'inventory_tag' => $item->inventory_tag,
                    'penalty_fee' => $item->penalty_fee,
                    'quantity' => $quantity,
                    'status' => $item->status,
                    'duration_type' => $item->duration_type,
                    'duration' => $item->duration,
                    'borrowed' => 'no',
                    'item_image' => $item->item_image,
                ]);
            }

            $item->update([
                'quantity' => $item->quantity - $quantity, // Deduct transferred quantity from original item
            ]);

            // Delete item from room_from if its quantity becomes zero or negative
            $existingItemFrom = Item::where('serial_number', $item->serial_number)
                ->where('location', $item->location)
                ->where('part_number', $item->part_number)
                ->first();

            if ($existingItemFrom && $existingItemFrom->quantity <= 0) {
                $existingItemFrom->delete(); // Delete item with zero or negative quantity
            }
        } else {
            $item->update([
                'location' => $request->room_to,
            ]);
        }
        return back()->with('success', 'Item #' . $id . ' transferred successfully.');
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
            'duration_type' => $replacedItem->duration_type,
            'penalty_fee' => $replacedItem->penalty_fee,
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
