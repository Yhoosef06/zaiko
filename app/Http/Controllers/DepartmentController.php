<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(10);

        return view('pages.admin.listOfDepartments', compact('departments'));
    }

    public function addDepartment()
    {
        $colleges = College::all();
        return view('pages.admin.addDepartment')->with(compact('colleges'));
    }

    public function saveNewDepartment(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'department_name' => 'required|unique:departments,department_name',
                ],
            );

            Department::create([
                'college_id' => $request->college_id,
                'department_name' => $request->department_name,
            ]);
            return redirect()->route('view_departments')->with('success', 'Department/Program added successfully!');
        } catch (\Exception $e) {

            return redirect()->route('view_departments')->with('danger', 'An error occurred while adding the department/program.');
        }
    }

    public function editDepartment($id)
    {
        $colleges = College::all();
        $department = Department::find($id);
        return view('pages.admin.editDepartment')->with(compact('department', 'colleges'));
    }

    public function saveEditedDepartment(Request $request, $id)
    {
        try {
            $department = Department::find($id);

            if (!$department) {
                return redirect('departments')->with('error', 'College not found.');
            }

            $department->update([
                'college_id' => $request->college_id,
                'department_name' => $request->department_name,
                // Add other fields you want to update here
            ]);

            return redirect('departments')->with('success', 'Department/Program edited successfully.');
        } catch (\Exception $e) {
            return redirect('departments')->with('danger', 'An error occurred while editing the department/program.');
        }
    }

    public function deleteDepartment($id)
    {
        try {
            $department = Department::find($id);

            $department->delete();

            Session::flash('success', 'Department/Program Successfully Removed');
            return redirect('departments');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove department because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('departments');
        }
    }

    public function getDepartments($college_id)
    {
        $departments = Department::where('college_id', $college_id)->get();
        
        return response()->json($departments);
    }
}
