<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        return view('pages.admin.listOfColleges')->with(compact('colleges'));
    }

    public function addCollege()
    {
        return view('pages.addCollege');
    }

    public function saveNewCollege(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'college_name' => 'required|unique:colleges,college_name',
                ],
            );

            College::create([
                'college_name' => $request->college_name,
            ]);
            return redirect()->route('view_colleges')->with('success', 'College added successfully!');
        } catch (\Exception $e) {

            return redirect()->route('view_colleges')->with('danger', 'An error occurred while adding the college.');
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
                // Add other fields you want to update here
            ]);

            return redirect('colleges')->with('success', 'College edited successfully.');
        } catch (\Exception $e) {
            return redirect('colleges')->with('danger', 'An error occurred while editing the college.');
        }
    }


    public function deleteCollege($id)
    {
        try {
            $college = College::find($id);

            $college->delete();

            Session::flash('success', 'College name successfully removed');
            return redirect('colleges');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove college because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('colleges');
        }
    }
}
