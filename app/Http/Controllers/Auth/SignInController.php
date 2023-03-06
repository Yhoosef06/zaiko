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
        $input = $request->all();
        $this->validate($request,[
            'id_number' => 'required',
            'password' => 'required'
        ]);
        
        
        
        // $this->validate($request, [
        //     'id_number' => 'required',
        //     'password' => 'required'
        // ]);

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
        

        if (auth()->attempt(['id_number' => $input['id_number'], 'password' => $input['password']])){
            if(auth()->user()->status == 'admin'){
                return redirect()->route('admin.dashboard');
            }else if(auth()->user()->status == 'student'){
                return redirect()->route('student.dashboard');
            }else{
                return redirect()->route('approval');
            }
        };

        return back()->with('status', 'Invalid login details');


        
    }
}
