<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('college')->get();

        $departments->each(function ($department) {
            $department->college_name = $department->college->college_name;
        });

        return view('pages.admin.listOfDepartments', compact('departments'));
    }

    public function deleteDepartment($id)
    {
        try {
            $department = Department::find($id);

            $department->delete();

            Session::flash('success', 'Successfully Removed');
            return redirect('departments');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('status', 'Cannot remove department because it is referenced by other records.');
            } else {
                Session::flash('status', 'An error occurred.');
            }
            return redirect('departments');
        }
    }
}
