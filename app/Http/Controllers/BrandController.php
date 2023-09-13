<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{

    public function index()
    {
        $dateTime = Carbon::now();
        $brands = Brand::withCount('models')->get();
        return view('pages.admin.listOfBrands')->with(compact('brands', 'dateTime'));
    }

    public function addBrand()
    {
        return view('pages.admin.addBrand');
    }

    public function saveNewBrand(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'brand_name' => 'required|unique:brands,brand_name',
                ],
            );

            Brand::create([
                'brand_name' => $request->brand_name,
            ]);
            if (Auth::user()->account_type == 'admin') {
                return redirect()->route('view_brands')->with('success', 'Brand name added successfully!');
            } else {
                return redirect('adding-new-item')->with('success', 'Brand name added successfully!');
            }
            
        } catch (\Exception $e) {
            if (Auth::user()->account_type == 'admin') {
                return redirect()->route('view_brands')->with('danger', 'An error occurred while adding the brand name.');
            } else {
                return redirect('adding-new-item')->with('danger', 'An error occurred while adding the brand name.');
            }
        }
    }

    public function editBrand($id)
    {
        $brand = Brand::find($id);
        return view('pages.admin.editBrand')->with(compact('brand'));
    }

    public function saveEditedBrand(Request $request, $id)
    {
        try {
            $brand = Brand::find($id);

            if (!$brand) {
                return redirect('brands')->with('error', 'Brand not found.');
            }

            $brand->update([
                'brand_name' => $request->brand_name,
            ]);

            return redirect('brands')->with('success', 'Brand edited successfully.');
        } catch (\Exception $e) {
            return redirect('brands')->with('danger', 'An error occurred while editing the brand.');
        }
    }

    public function deleteBrand($id)
    {
        try {
            $brand = Brand::find($id);
            $brand->delete();

            Session::flash('success', 'Brand Successfully Removed');
            return redirect('brands');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove brand because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('brands');
        }
    }
}
