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
        $this->validate($request, [ 
            'id_number' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt(['id_number' => $input['id_number'], 'password' => $input['password']])) {
            if (auth()->user()->account_type == 'admin') {
                return redirect()->route('admin.dashboard');
            } else if (auth()->user()->role == 'manager') {
                $userId = auth()->user()->id_number;
                $user = User::find($userId);
                if ($user) {
                    $user->update([
                        'last_login_at' => now()
                    ]);
                }
                return redirect()->route('admin.dashboard');
            }  else if (auth()->user()->role == 'borrower') {
                $userId = auth()->user()->id_number;
                $user = User::find($userId);
                if ($user) {
                    $user->update([
                        'last_login_at' => now()
                    ]);
                }
                return redirect()->route('student.dashboard');
            }
        };

        return back()->with('status', 'Invalid I.D. Number or Password');
    }
}
