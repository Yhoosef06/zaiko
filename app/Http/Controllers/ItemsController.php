<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;

class ItemsController extends Controller
{
    public function index()
    {
        //admin
        $items = Item::paginate(10);   
        return view('pages.admin.listOfItems', [
            'items' => $items
        ]);
    }

    public function viewItemDetails($serial_number)
    {
        $item = Item::find($serial_number);
        return view('pages.admin.viewItemDetails')->with('item',$item);
    }

    public function editItemPage($serial_number)
    {
        $item = Item::find($serial_number);
        $rooms = Room::all();
        return view('pages.admin.editItem')->with(compact('item','rooms'));
    }

    public function saveEditedItemDetails(Request $request, $serial_number)
    {   
        
        $item = Item::find($serial_number);
        $item->serial_number = $request->serial_number;
        $item->location = $request->location;
        $item->item_description = $request->item_description;
        $item->aquisition_date = $request->aquisition_date;
        $item->unit_number = $request->unit_number;
        $item->quantity = $request->quantity;
        $item->status = $request->status;
        $item->borrowed = $request->borrowed;
        $item->inventory_tag = $item->inventory_tag;
        $item->update();

        return redirect('list-of-items')->with('status', 'Item '.$serial_number.' has been updated.');
    }

    public function deleteItem($serial_number)
    {
        $item = Item::find($serial_number);
        $item->delete();
        return redirect('list-of-items')->with('status', 'Item '.$serial_number.' removed successfully.');   
    }

    public function saveNewItem(Request $request)
    {
        // dd($request->inventory_tag);
        $this->validate($request,[
            'serial_number' => 'required|max:20',
            'location' => 'required',
            'item_description' => 'required',
            'aquisition_date' => 'nullable',
            'unit_number' => 'required',
            'inventory_tag' => 'required',
            'quantity' => 'required|numeric',
            'status' => 'required',
            'borrowed' => 'required'
        ]);

        Item::create([
            'serial_number' => $request->serial_number,
            'location' => $request->location,
            'item_description' => $request->item_description,
            'aquisition_date' => $request->aquisition_date,
            'unit_number' => $request->unit_number,
            'inventory_tag' => $request->inventory_tag,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'borrowed' => $request->borrowed
        ]);

        return redirect('/adding-new-item')->with('status', 'Item Successfully Added! Do you want to add another item?');
    }
    
}
