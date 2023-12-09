<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::withCount('departments')->paginate(10);

        return view('pages.admin.listOfColleges')->with(compact('colleges'));
    }

    public function addCollege()
    {
        return view('pages.addCollege');
    }

    public function saveNewCollege(Request $request)
    {
        try {
            $validator = $this->validate(
                $request,
                [
                    'college_name' => 'required|unique:colleges,college_name',
                ],
                [
                    'college_name.required' => 'College name is required.',
                    'college_name.unique' => 'College name already exists.',
                ]
            );

            College::create([
                'college_name' => $request->college_name,
            ]);

            return response()->json(['success' => true, 'message' => 'New college has been added.']);
        } catch (ValidationException $e) {
            // Validation failed
            $errors = $e->validator->errors()->messages();
            return response()->json(['success' => false, 'errors' => $errors], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Encountered an error while adding college.'], 500);
        }
    }
    public function editCollege($id)
    {
        $college = College::find($id);
        return view('pages.editCollege')->with(compact('college'));
    }

    public function saveEditedCollege(Request $request, $id)
    {
        try {
            $college = College::find($id);

            if (!$college) {
                return redirect('colleges')->with('error', 'College not found.');
            }

            $college->update([
                'college_name' => $request->college_name,
            ]);

            return redirect('colleges')->with('success', 'College edited successfully');
        } catch (\Exception $e) {
            return redirect('colleges')->with('danger', 'An error occurred while editing the college');
        }
    }
    public function deleteCollege($id)
    {
        try {
            $college = College::find($id);
            $college->delete();

            return response()->json(['success' => true, 'message' => 'College successfully removed']);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json(['success' => false, 'message' => 'Cannot remove college because it is referenced by other records']);
            } else {
                return response()->json(['success' => false, 'message' => 'An error occurred']);
            }
        }
    }

}
