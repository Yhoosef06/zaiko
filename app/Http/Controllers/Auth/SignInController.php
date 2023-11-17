<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            'id_number' => 'required|regex:/^[a-zA-Z0-9]*$/',
            'password' => 'required'
        ]);

        if (auth()->attempt(['id_number' => $input['id_number'], 'password' => $input['password']])) {
            $userId = auth()->user()->id_number;
            $user = User::find($userId);
            
            if ($user->roles->contains('name', 'admin')) {
                $userRole = Auth::user()->roles-> contains('name', 'admin');
                // dd($userRole);
                return redirect()->route('admin.dashboard');
            } else if ($user->roles->contains('name', 'manager')) {

                if ($user) {
                    $user->update([
                        'last_login_at' => now()
                    ]);
                }
                if (auth()->user()->password_updated == false) {
                    return redirect()->route('change_user_password', ['id_number' => auth()->user()->id_number]);
                } elseif (auth()->user()->security_question_id == null) {
                    return redirect()->route('setup_security_question', ['id_number' => auth()->user()->id_number]);
                } else {
                    return redirect()->route('admin.dashboard');
                }
            } else if($user->roles->contains('name', 'borrower')) {
                $userId = auth()->user()->id_number;
                $user = User::find($userId);
                if ($user) {
                    $user->update([
                        'last_login_at' => now()
                    ]);
                }
                if (auth()->user()->password_updated == false) {
                    return redirect()->route('change_user_password', ['id_number' => auth()->user()->id_number]);
                } elseif (auth()->user()->security_question_id == null) {
                    return redirect()->route('setup_security_question', ['id_number' => auth()->user()->id_number]);
                } else {
                    return redirect()->route('borrower.dashboard');
                }
            }
        };

        return back()->with('status', 'Invalid I.D. Number or Password');
    }
}
