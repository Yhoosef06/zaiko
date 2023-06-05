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

    public function deleteCollege($id)
    {
        try {
            $college = College::find($id);

            $college->delete();

            Session::flash('success', 'Successfully Removed');
            return redirect('colleges');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('status', 'Cannot remove college because it is referenced by other records.');
            } else {
                Session::flash('status', 'An error occurred.');
            }
            return redirect('colleges');
        }
    }
}
