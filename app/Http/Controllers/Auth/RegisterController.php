<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.register');
    }

    public function store(Request $request)
    {
        // @dd($request);
        $this->validate($request, [
            'id_number' => 'required|numeric',
            'first_name' => 'required|regex:/^([^0-9]*)$/',
            'last_name' => 'required|regex:/^([^0-9]*)$/',
            'password' => 'required|confirmed|min:7',
            'front_of_id' => 'required',
            'back_of_id' => 'required'
        ]);



        $user = User::where('id_number', '=', $request->input('id_number'))->first();

        if ($user === null) {
            User::create([
                'id_number' => $request->id_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),

                'front_of_id' =>  $request->file('front_of_id')->storeAs(
                    'ids',
                    $request->id_number . 'frontID.' . $request->file('front_of_id')->getClientOriginalExtension(),
                    'public',
                ),

                'back_of_id' =>  $request->file('back_of_id')->storeAs(
                    'ids',
                    $request->id_number . 'backID.' . $request->file('back_of_id')->getClientOriginalExtension(),
                    'public',
                ),
                
                'account_type' => 'student',
                'account_status' => 'pending'
            ]);

            return redirect('/')->with('status', 'Please wait for approval from the officer-in-charge before you can login. Thank you.');
        } else {
            return redirect('register')->with('status', 'That ID number has already been registered');
        }
    }
}
