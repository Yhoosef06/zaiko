<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;

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
}
