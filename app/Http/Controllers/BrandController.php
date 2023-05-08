<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function storeNewBrand(Request $request)
    {
        
        // $this->validate(
        //     $request,
        //     [
        //         'room_name' => 'required|regex:/[A-Z]+/|min:3'
        //     ]
        // );

        $brand= Brand::where('brand_name', '=', $request->input('brand'))->first();
        if ($brand === null) {
            Brand::create([
                'brand_name' => $request->brand,
            ]);
            Session::flash('success', $request->brand.' successfully added.');
            return redirect('adding-new-item');
        } else {
            Session::flash('status', $request->brand.' has already been added.');
            return redirect('adding-new-item');
        }
    }
}
