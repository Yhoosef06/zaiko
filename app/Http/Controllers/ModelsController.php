<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Models;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class ModelsController extends Controller
{
    public function index()
    {
        $models = Models::with('brand')->get();

        $models->each(function ($models) {
            $models->brand_name = $models->brand->brand_name;
        });
        return view('pages.admin.listOfModels')->with(compact('models'));
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
            return redirect()->route('view_models')->with('success', 'Model name added successfully!');
        } catch (\Exception $e) {

            return redirect()->route('view_models')->with('danger', 'An error occurred while adding the model name.');
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
            $model= Models::find($id);

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
                Session::flash('danger', 'Cannot remove room because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('brands');
        }
    }
}
