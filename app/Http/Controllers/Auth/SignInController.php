<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SignInController extends Controller
{
    public function index()
    {
        return view('pages.signin');
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'id_number' => 'required',
            'password' => 'required'
        ]);

        // $id_number = $request->id_number;
        // dd(auth()->user()->first_name);
        // $user = User::find($id_number);
        // $status = $user->status;
        // dd($user);

        // if () {

        //     dd('Admin Account!');
        // } else {
        //     dd('Student Account!');
        // }
        

        if (!auth()->attempt($request->only('id_number', 'password'))){
            return back()->with('status', 'Invalid login details');
        };



        return redirect()->route('dashboard');
    }
}
