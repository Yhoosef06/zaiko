<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{

    public function index()
    {
        $brands = Brand::all();
        return view('pages.admin.listOfBrands')->with(compact('brands'));
    }

    public function storeNewBrand(Request $request)
    {
        // Validate the input
        $request->validate([
            'brand' => 'required',
        ]);

        $brand = Brand::where('brand_name', '=', $request->input('brand'))->first();
        if ($brand) {
            return response()->json(['error' => $request->brand.' brand has already been added.'], 422);
        }

        Brand::create([
            'brand_name' => $request->brand,
        ]);
        return response()->json(['success' => $request->brand . ' brand successfully added.'], 200);
    }
}
