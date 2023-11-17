<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function storeSelectedCategory(Request $request)
    {
        $selectedCategory = $request->input('selectedCategory');
        Session::put('selectedCategory', $selectedCategory);
        return response()->json(['success' => true]);
    }

    public function storeSelectedDepartment(Request $request)
    {
        $selectedDepartment = $request->input('selectedDepartment');
        Session::put('selectedDepartment', $selectedDepartment);
        return response()->json(['success' => true]);
    }

}
