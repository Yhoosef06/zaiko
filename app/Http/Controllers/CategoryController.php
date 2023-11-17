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
}
