<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\SecurityQuestion;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function selectRegistrationType()
    {
        return view('pages.selectRegistrationType');
    }

    public function studentRegistration()
    {
        $departments = Department::with('college')->get();

        $securityQuestions = SecurityQuestion::all();

        $departments->each(function ($department) {
            $department->college_name = $department->college->college_name;
        });

        return view('pages.registerStudent')->with(compact('departments', 'securityQuestions'));
    }

    public function facultyRegistration()
    {
        $departments = Department::with('college')->get();

        $securityQuestions = SecurityQuestion::all();

        $departments->each(function ($department) {
            $department->college_name = $department->college->college_name;
        });

        return view('pages.registerFaculty')->with(compact('departments', 'securityQuestions'));
    }

    public function storeStudent(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'id_number' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'department_id' => 'required',
            'password' => 'required|confirmed|min:7',
            // 'question' => 'required|exists:security_questions,id',
            // 'answer' => 'required|string',
        ]);

        $user = User::where('id_number', '=', $request->input('id_number'))->first();

        if ($user === null) {
            User::create([
                'id_number' => $request->id_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),
                'password_updated' => 1,
                'account_type' => 'student',
                'account_status' => 'pending',
                'role' => 'borrower',
                'department_id' => $request->department_id,
            ]);
            return redirect('/')->with('message', 'Account successfully submitted! Please wait for approval from the officer-in-charge before you can login. Thank you.');
        } else {
            return redirect('student-registration')->with('status', 'That ID number has already been registered');
        }
    }

    public function storeFaculty(Request $request)
    {
        $this->validate($request, [
            'id_number' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'department_id' => 'required',
            'password' => 'required|confirmed|min:7',
        ]);

        $user = User::where('id_number', '=', $request->input('id_number'))->first();

        if ($user === null) {
            User::create([
                'id_number' => $request->id_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),
                'password_updated' => 1,
                'account_type' => 'faculty',
                'account_status' => 'pending',
                'role' => 'borrower',
                'department_id' => $request->department_id,
            ]);

            return redirect('/')->with('message', 'Account successfully submitted! Please wait for approval from the officer-in-charge before you can login. Thank you.');
        } else {
            return redirect('faculty-registration')->with('status', 'That ID number has already been registered');
        }
    }
}
