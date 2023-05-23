<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $departments = Department::with('college')->get();

        $departments->each(function ($department) {
            $department->college_name = $department->college->college_name;
        });

        return view('pages.register')->with(compact('departments'));
    }

    public function store(Request $request)
    {
        // @dd($request);
        $this->validate($request, [
            'id_number' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:7',
        ]);



        $user = User::where('id_number', '=', $request->input('id_number'))->first();

        if ($user === null) {
            User::create([
                'id_number' => $request->id_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),

                // 'front_of_id' =>  $request->file('front_of_id')->storeAs(
                //     'ids',
                //     $request->id_number . 'frontID.' . $request->file('front_of_id')->getClientOriginalExtension(),
                //     'public',
                // ),

                // 'back_of_id' =>  $request->file('back_of_id')->storeAs(
                //     'ids',
                //     $request->id_number . 'backID.' . $request->file('back_of_id')->getClientOriginalExtension(),
                //     'public',
                // ),

                'account_type' => 'student',
                'account_status' => 'pending',
                'department_id' => $request->department_id
            ]);

            return redirect('/')->with('status', 'Please wait for approval from the officer-in-charge before you can login. Thank you.');
        } else {
            return redirect('register')->with('status', 'That ID number has already been registered');
        }
    }
}
