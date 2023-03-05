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
        $this->validate($request, [
            'id_number' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'front_of_id' => 'required',
            'back_of_id' => 'required'
        ]);

        User::create([
            'id_number' => $request->id_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make('usjrscs-123'),
            'front_of_id' => $request->file('front_of_id')->store(('ids')),
            'back_of_id' => $request->file('back_of_id')->store(('ids')),
            'status' => 'queued'
        ]);

        return redirect('/signin')->with('status', 'Please wait for approval from the officer-in-charge before you can login. Thank you.');
    }
}
