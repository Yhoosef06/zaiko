<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class ItemCategoryController extends Controller
{

    public function index()
    {
        $dateTime = Carbon::now();
        $categories = ItemCategory::withCount('items')->get();

        return view('pages.admin.listOfItemCategories')->with(compact('categories', 'dateTime'));
    }

    public function addItemCategory()
    {
        return view('pages.admin.addItemCategory');
    }

    public function editItemCategory($id)
    {
        $category = ItemCategory::find($id);
        return view('pages.admin.editItemCategory')->with(compact('category'));
    }

    public function saveEditedItemCategory(Request $request, $id)
    {
        try {
            $category = ItemCategory::find($id);

            if (!$category) {
                return redirect('colleges')->with('error', 'Item Category not found.');
            }

            $category->update([
                'category_name' => $request->category_name,
                // Add other fields you want to update here
            ]);

            return redirect('item-categories')->with('success', 'Item category edited successfully.');
        } catch (\Exception $e) {
            return redirect('item-categories')->with('danger', 'An error occurred while editing the item category.');
        }
    }

    public function saveNewCategory(Request $request)
    {
        $categories = ItemCategory::all();
        try {
            // Validate the input
            $request->validate([
                'category_name' => 'required|unique:item_categories,category_name',
            ]);

            ItemCategory::create([
                'category_name' => $request->category_name,
            ]);

            return back()->with('success', 'New item category has been added.');
        } catch (\Exception $e) {
            return back()->with('danger', 'An error has occured while adding the new item category.');
        }
    }

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

            Session::flash('success', 'Item category successfully removed.');
            return redirect('item-categories');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove item category because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('item-categories');
        }
    }
}
