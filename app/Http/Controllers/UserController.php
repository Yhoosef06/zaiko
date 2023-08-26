<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\SecurityQuestion;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\Console\Question\Question;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //admin
        if (Auth::user()->account_type == 'admin') {
            $users = User::all();
            $departments = Department::all();

            return view('pages.admin.listOfUsers')->with(compact('users', 'departments'));
        } else if (Auth::user()->account_type == 'faculty') {
            $userDeptId = Auth::user()->department_id;
            $userCollegeId = Department::where('id', $userDeptId)->value('college_id');

            $users = User::where('account_type', 'student')
                ->whereHas('departments', function ($query) use ($userCollegeId) {
                    $query->where('college_id', $userCollegeId);
                })
                ->orderBy('id_number', 'DESC')
                ->get();
            $departments = Department::all();
            return view('pages.admin.listOfUsers')->with(compact('users', 'departments'));
        }
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

        $department = $user->departments->department_name;

        $user['department'] = $department;

        // dd($user);
        // return response()->json($user);
        return view('pages.admin.viewUserInfo')->with(compact('user'));
    }

    public function addUser()
    {
        $securityQuestions = SecurityQuestion::all();

        if (Auth::user()->account_type != 'admin') {

            $user_dept_id = Auth::user()->department_id;
            $user_department = Department::find($user_dept_id);
            $user_college_id = $user_department->college_id;

            $departments = Department::with('college')->where('college_id', $user_college_id)->get();
            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });

            return view('pages.admin.addUser')->with(compact('departments', 'securityQuestions'));
        } else {
            $departments = Department::with('college')->get();

            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });
            return view('pages.admin.addUser')->with(compact('departments', 'securityQuestions'));
        }
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
                'department_id' => 'required',
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
                'role' => $request->role,
                'department_id' => $request->department_id,
                'password' => Hash::make('default'),
                // 'front_of_id' => $request->file('front_of_id')->store(('ids')),
                // 'back_of_id' => $request->file('back_of_id')->store(('ids')),
            ]);
            Session::flash('success', 'User Successfully Added. Do you want to add another user?');
            return redirect('add-new-user');
        } else {
            Session::flash('danger', 'I.D. Number has already been used.');
            return redirect('add-new-user');
        }
    }

    public function deleteUser($id_number)
    {
        try {
            $user = User::find($id_number);

            $user->delete();

            Session::flash('success', 'Account ' . $id_number . ' successfully removed.');
            return redirect('list-of-users');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove college because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('colleges');
        }
    }

    public function editUserInfo($id_number)
    {
        $user = User::find($id_number);

        $departments = Department::with('college')->get();

        $departments->each(function ($department) {
            $department->college_name = $department->college->college_name;
        });


        return view('pages.admin.editUserInfo')->with(compact('user', 'departments'));
    }

    public function saveEditedUserInfo(Request $request, $id_number)
    {
        $user = User::find($id_number);
        $user->id_number = $request->id_number;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->account_type = $request->account_type;
        $user->account_status = $request->account_status;
        $user->role = $request->role;
        $user->department_id = $request->department_id;
        $user->update();

        Session::flash('success', 'User ' . $id_number . ' has been updated.');
        return redirect('list-of-users');
    }

    public function changeUserPassword($id_number)
    {
        $user = User::find($id_number);

        if (Auth::user()->id_number == $id_number) {
            return view('pages.admin.changeProfilePassword')->with('user', $user);
        } else {
            return view('pages.admin.changeUserPassword')->with('user', $user);
        }
    }

    public function saveUserNewPassword(Request $request, $id_number)
    {
        $request->validate([
            'new_password' => 'required|min:7',
            'password_confirmation' => ['same:new_password'],
        ]);

        User::find($id_number)->update(['password' => Hash::make($request->new_password)]);

        if ($id_number == Auth::user()->id_number) {
            if (Auth::user()->security_question_id == null) {
                $securityQuestions = SecurityQuestion::all();
                return view('pages.auth.setupSecurityQuestion')->with('securityQuestions', $securityQuestions);;
            } else {
                return redirect('/')->with('message', 'Password changed successfully. Please login with new password.');
            }
        } else {
            Session::flash('success', 'User ' . $id_number . ' password has been changed.');
            return redirect('list-of-users');
        }
    }

    //AUTH
    public function viewProfile($id_number)
    {
        $user = User::find($id_number);

        return view('pages.userProfile')->with('user', $user);
    }

    public function editProfile($id_number)
    {
        $user = User::find($id_number);
        $departments = Department::with('college')->get();
        $departments->each(function ($department) {
            $department->college_name = $department->college->college_name;
        });

        return view('pages.editProfile')->with(compact('user', 'departments'));
    }

    public function saveEditedProfileInfo(Request $request, $id_number)
    {
        User::find($id_number)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'departmen_id' => $request->department
        ]);

        return redirect('profile-' . $id_number . '')->with('success', 'Profile Edited Sucessfully.');
    }

    public function modifySecurityQuestion($id_number)
    {
        $user = User::find($id_number);
        $securityQuestions = SecurityQuestion::all();
        if ($user->security_question_id == null) {

            return view('pages.auth.setupSecurityQuestion')->with(compact('securityQuestions'));
        } else {
            $question_id = $user->security_question_id;
            $questions = SecurityQuestion::find($question_id);
        }
        return view('pages.modifySecurityQuestion')->with(compact('questions', 'securityQuestions'));
    }


    public function saveModifiedSecurityQuestion(Request $request, $id_number)
    {
        User::find($id_number)->update([
            'security_question_id' => $request->question,
            'answer' => $request->answer
        ]);

        return redirect('profile-' . $id_number . '')->with('success', 'Security Question Modified Sucessfully.');
    }
}
