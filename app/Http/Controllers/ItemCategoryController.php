<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ItemCategoryController extends Controller
{

    public function index()
    {
        $categories = ItemCategory::withCount('items')
            ->orderBy('category_name', 'asc')
            ->paginate(10);

        return view('pages.admin.listOfItemCategories')->with(compact('categories'));
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
        try {
            $validator = $this->validate(
                $request,
                [
                    'category_name' => 'required|unique:item_categories,category_name',
                ],
                [
                    'category_name.required' => 'Category name is required.',
                    'category_name.unique' => 'Category name already exists.',
                ]
            );

            ItemCategory::create([
                'category_name' => $request->category_name,
            ]);

            return response()->json(['success' => true, 'message' => 'New item category has been added.']);
        } catch (ValidationException $e) {
            // Validation failed
            return response()->json(['success' => false, 'errors' => $e->validator->errors()->messages()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Encountered an error when adding category.'], 500);
        }
    }

    public function deleteCategory($id)
    {
        try {
            $category = ItemCategory::find($id);
            $category->delete();

            return response()->json(['success' => true, 'message' => 'Item category successfully removed']);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json(['success' => false, 'message' => 'Cannot remove item category because it is referenced by other records']);
            } else {
                return response()->json(['success' => false, 'message' => 'An error occurred']);
            }
        }
    }

}
