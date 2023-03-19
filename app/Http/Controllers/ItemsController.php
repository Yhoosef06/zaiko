<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Symfony\Contracts\Service\Attribute\Required;

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
        return view('pages.admin.viewItemDetails')->with('item', $item);
    }

    public function editItemPage($serial_number)
    {
        $item = Item::find($serial_number);
        $rooms = Room::all();
        return view('pages.admin.editItem')->with(compact('item', 'rooms'));
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
        $item->inventory_tag = $request->inventory_tag;
        $item->update();

        return redirect('list-of-items')->with('status', 'Item ' . $serial_number . ' has been updated.');
    }

    public function deleteItem($serial_number)
    {
        $item = Item::find($serial_number);
        $item->delete();
        return redirect('list-of-items')->with('status', 'Item ' . $serial_number . ' removed successfully.');
    }

    public function saveNewItem(Request $request)
    {
        // dd($request->inventory_tag);
        $this->validate($request, [
            'serial_number' => 'required|max:20',
            'location' => 'required',
            'item_name' => 'required',
            'item_description' => 'required',
            'aquisition_date' => 'nullable',
            'unit_number' => 'required',
            'inventory_tag' => 'required',
            'quantity' => 'required|numeric',
            'status' => 'required',
        ]);

        Item::create([
            'serial_number' => $request->serial_number,
            'location' => $request->location,
            'item_name' => $request->item_name,
            'item_description' => $request->item_description,
            'aquisition_date' => $request->aquisition_date,
            'unit_number' => $request->unit_number,
            'inventory_tag' => $request->inventory_tag,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'borrowed' => 'no'
        ]);

        return redirect('/adding-new-item')->with('status', 'Item Successfully Added! Do you want to add another item?');
    }

    public function generateReportPage()
    {
        $rooms = Room::all();
        return view('pages.admin.report')->with(compact('rooms'));
    }

    public function downloadReport(Request $request)
    {
        $this->validate(
            $request,
            [
                'location' => 'required',
                'purpose' => 'nullable',
                'department' => 'required',
                'prepared_by' => 'required',
                'verified_by' => 'required',
                'lab_oic' => 'required',
                'it_specialist' => 'required'
            ]
        );

        $purpose = $request->purpose;
        $department = $request->department;
        $location = $request->location;
        $prepared_by = $request->prepared_by;
        $verified_by = $request->verified_by;
        $lab_oic = $request->lab_oic;
        $it_specialist = $request->it_specialist;

        $items = Item::orderBy('unit_number', 'ASC')->get();

        if ($request->has('download')) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pages.pdfReport', compact('items', 'purpose', 'location', 
            'prepared_by','verified_by','lab_oic','it_specialist','department'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4');

            return $pdf->download('InventoryReport' . $location . '.pdf');
        }

        return view('pages.pdfReport')->with(compact('items', 'location', 'purpose', 
        'prepared_by','verified_by','lab_oic','it_specialist','department'));
    }
    public function searchItem(Request $request)
    {
        $search_text = $_GET['query'];

        $items = Item::where('item_name', 'LIKE', '%' . $search_text . '%')
            ->orWhere('location', 'LIKE', '%' . $search_text . '%')
            ->orWhere('item_description', 'LIKE', '%' . $search_text . '%')
            ->orWhere('serial_number', 'LIKE', '%' . $search_text . '%')->paginate(5);

        return view('pages.admin.listOfItems', compact('items'));
    }
}
