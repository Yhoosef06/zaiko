<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class ItemCategoryController extends Controller
{

    public function index()
    {
        $categories = ItemCategory::all();
        return view('pages.admin.listOfItemCategories')->with(compact('categories'));
    }

    // public function storeNewCategory(Request $request)
    // {

    //     // $this->validate(
    //     //     $request,
    //     //     [
    //     //         'room_name' => 'required|regex:/[A-Z]+/|min:3'
    //     //     ]
    //     // );

    //     $category = ItemCategory::where('category_name', '=', $request->input('category_name'))->first();
    //     if ($category === null) {
    //         ItemCategory::create([
    //             'category_name' => $request->category_name,
    //         ]);
    //         Session::flash('success', $request->category_name . ' category successfully added.');
    //         return redirect('adding-new-item');
    //     } else {
    //         Session::flash('status', $request->category_name . ' category has already been added.');
    //         return redirect('adding-new-item');
    //     }
    // }

    public function storeNewCategory(Request $request)
    {
        // Validate the input
        $request->validate([
            'category_name' => 'required',
        ]);

        $category = ItemCategory::where('category_name', '=', $request->input('category_name'))->first();
        if ($category) {
            return response()->json(['error' => 'Category has already been added.'], 400);
        }
        
        ItemCategory::create([
            'category_name' => $request->category_name,
        ]);
        return response()->json(['success' => $request->category_name . ' category successfully added.'], 200);
    }

    public function deleteCategory($id)
    {
        try {
            $category = ItemCategory::find($id);
            $category->delete();

            Session::flash('success', 'Successfully Removed');
            return redirect('item-categories');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('status', 'Cannot remove category because it is referenced by other records.');
            } else {
                Session::flash('status', 'An error occurred.');
            }
            return redirect('item-categories');
        }
    }
}
