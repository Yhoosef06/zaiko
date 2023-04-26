<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //admin
        $users = User::orderBy('updated_at', 'DESC')->paginate(10);
        return view('pages.admin.listOfUsers', [
            'users' => $users
        ]);
    }

    public function searchUser(Request $request)
    {
        $search_text = request('query');

        $users = User::where('id_number', 'LIKE', '%' . $search_text . '%')
            ->orWhere('first_name', 'LIKE', '%' . $search_text . '%')
            ->orWhere('last_name', 'LIKE', '%' . $search_text . '%')
            ->orWhere('account_type', 'LIKE', '%' . $search_text . '%')
            ->orWhere('account_status', 'LIKE', '%' . $search_text . '%')->paginate(5);

        return view('pages.admin.listOfUsers', compact('users'));
    }

    public function viewUserInfo($id_number)
    {
        $user = User::find($id_number);
        return view('pages.admin.viewUserInfo')->with('user', $user);
    }

    public function addUser()
    {
        return view('pages.admin.addUser');
    }

    public function saveNewUser(Request $request)
    {

        $this->validate(
            $request,
            [
                'id_number' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'account_type' => 'required',
                'account_status' => 'required',
                'password' => 'required|confirmed|min:7',
            ]
        );

        $user = User::where('id_number', '=', $request->input('id_number'))->first();
        if ($user === null) {
            User::create([
                'id_number' => $request->id_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'account_type' => $request->account_type,
                'account_status' => $request->account_status,
                'password' => Hash::make($request->password),
                // 'front_of_id' => $request->file('front_of_id')->store(('ids')),
                // 'back_of_id' => $request->file('back_of_id')->store(('ids')),
            ]);
            Session::flash('success', 'User Successfully Added. Do you want to add another user?');
            return redirect('add-new-user');
        } else {
            Session::flash('message', 'I.D. Number has already been used.');
            return redirect('add-new-user');
        }
    }

    public function deleteUser(Request $request, $id_number)
    {
        $id = $request->id_number;
        // echo $id;
        // exit;
        $user = User::find($id);
        $user->delete();
        Session::flash('success', 'Successfuly Removed User: ' . $id);
        return redirect('list-of-users');
    }

    public function editUserInfo($id_number)
    {
        $user = User::find($id_number);

        return view('pages.admin.editUserInfo')->with('user', $user);
    }

    public function saveEditedUserInfo(Request $request, $id_number)
    {

        $user = User::find($id_number);
        $user->id_number = $request->id_number;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->account_type = $request->account_type;
        $user->account_status = $request->account_status;
        $user->update();

        Session::flash('success', 'User ' . $id_number . ' has been updated.');
        return redirect('list-of-users');
    }

    public function changeUserPassword($id_number)
    {
        $user = User::find($id_number);
        return view('pages.admin.changeUserPassword')->with('user', $user);
    }

    public function saveUserNewPassword(Request $request, $id_number)
    {
        $request->validate([
            // 'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:7',
            'password_confirmation' => ['same:new_password'],
        ]);

        User::find($id_number)->update(['password' => Hash::make($request->new_password)]);

        if ($id_number == auth()->user()->id_number) {
            return redirect('signin')->with('status', 'Password updated. Please login with new password.');
        } else {
            return redirect('list-of-users')->with('status', 'User ' . $id_number . ' password updated successfully.');
        }
    }
}
