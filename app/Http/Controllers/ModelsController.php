<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class ModelsController extends Controller
{
    public function index()
    {
        $dateTime = Carbon::now();
        $models = Models::with('brand')->paginate(10);
        $brands = Brand::orderBy('brand_name', 'asc')->get();
        $models->each(function ($models) {
            $models->brand_name = $models->brand->brand_name;
        });
        return view('pages.admin.listOfModels')->with(compact('models', 'dateTime', 'brands'));
    }

    public function getModels($brandId)
    {
        $models = Models::where('brand_id', $brandId)->get();

        return response()->json($models);
    }

    public function getFilteredModels(Request $request)
    {
        $brands = Brand::orderBy('brand_name', 'asc')->get();
        $brandIds = $request->input('brand_ids', []);
        $models = Models::whereIn('brand_id', $brandIds)->paginate(10); 
        return view('pages.admin.listOfModels', compact('models','brands'));
    }
    public function searchModel(Request $request)
    {
        $brands = Brand::orderBy('brand_name', 'asc')->get();
        $searchText = $request->input('search');
        $models = Models::where('model_name', 'like', '%' . $searchText . '%')
                        ->paginate(10);

       return view('pages.admin.listOfModels', compact('models','brands'));
    }

    public function addModel()
    {
        $brands = Brand::all();
        return view('pages.admin.addModel')->with(compact('brands'));
    }

    public function saveNewModel(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'model_name' => 'required|unique:models,model_name',
                ],
            );

            Models::create([
                'brand_id' => $request->brand_id,
                'model_name' => $request->model_name,
            ]);

            return back()->with('success', 'Model name added successfully!');
        } catch (\Exception $e) {

            return back()->with('danger', 'An error occurred while adding the model name.');
        }
    }

    public function editModel($id)
    {
        $brands = Brand::all();
        $model = Models::find($id);
        return view('pages.admin.editModel')->with(compact('model', 'brands'));
    }

    public function saveEditedModel(Request $request, $id)
    {
        try {
            $model = Models::find($id);

            if (!$model) {
                return redirect('models')->with('error', 'Model not found.');
            }

            $model->update([
                'brand_id' => $request->brand_id,
                'model_name' => $request->model_name,
                // Add other fields you want to update here
            ]);

            return redirect('models')->with('success', 'Model edited successfully.');
        } catch (\Exception $e) {
            return redirect('models')->with('danger', 'An error occurred while editing the model.');
        }
    }

    public function deleteModel($id)
    {
        try {
            $model = Models::find($id);
            $model->delete();

            Session::flash('success', 'Model Successfully Removed');
            return redirect('models');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove model because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('models');
        }
    }
}
