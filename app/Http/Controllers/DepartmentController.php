<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        $departments = Department::all();
        // $departments = $college->departments;
        // dd($college->departments);
        return view('pages.admin.listOfDepartments')->with(compact('colleges', 'departments'));
    }
}
