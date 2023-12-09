<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{

    public function index()
    {
        $dateTime = Carbon::now();
        $brands = Brand::withCount('models')->paginate(10);
        return view('pages.admin.listOfBrands')->with(compact('brands', 'dateTime'));
    }

    public function addBrand()
    {
        return view('pages.admin.addBrand');
    }

    public function saveNewBrand(Request $request)
    {
        try {
            $validator = $this->validate(
                $request,
                [
                    'brand_name' => 'required|unique:brands,brand_name',
                ],
                [
                    'brand_name.required' => 'Brand name is required.',
                    'brand_name.unique' => 'Brand name already exists.',
                ]
            );

            Brand::create([
                'brand_name' => $request->brand_name,
            ]);

            return response()->json(['success' => true, 'message' => 'New brand name has been added.']);
        } catch (ValidationException $e) {
            // Validation failed
            return response()->json(['success' => false, 'errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while adding the brand name.'], 500);
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

            return response()->json(['success' => true, 'message' => 'Brand successfully removed']);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json(['success' => false, 'message' => 'Cannot remove brand because it is referenced by other records']);
            } else {
                return response()->json(['success' => false, 'message' => 'An error occurred']);
            }
        }
    }

    public function searchBrand(Request $request)
    {
        $searchText = $request->input('search');
        $brands = Brand::where('brand_name', 'like', '%' . $searchText . '%')->paginate(10);

        return view('pages.admin.listOfBrands', compact('brands'));
    }
}
