<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Term;
use App\Models\User;
use App\Models\College;
use App\Models\UserRole;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserDepartment;
use App\Rules\MatchOldPassword;
use App\Models\SecurityQuestion;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use App\Jobs\SendTemporaryPasswordEmailJob;
use Symfony\Component\Console\Question\Question;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sortOrder = 'asc';
        $users = User::paginate(15);
        $filterUsers = User::all();
        $uniqueRoles = $filterUsers->flatMap(function ($user) {
            return $user->roles;
        })->unique('id');
        return view('pages.admin.listOfUsers')->with(compact('users', 'filterUsers', 'uniqueRoles'));
    }

    public function getFilteredUsers(Request $request)
    {
        $roleIds = $request->input('role_ids', []);
        $status = $request->input('status');
        $account_type = $request->input('account_type');
        $sortOrder = 'asc';

        $filterUsers = User::all();
        $uniqueRoles = $filterUsers->flatMap(function ($user) {
            return $user->roles;
        })->unique('id');

        $filteredUsers = User::query();

        if (!empty($roleIds)) {
            if (!is_array($roleIds)) {
                $roleIds = [$roleIds];
            }
            $filteredUsers->whereHas('roles', function ($query) use ($roleIds) {
                $query->whereIn('role_id', $roleIds);
            });
        }

        if (!empty($status)) {
            $filteredUsers->where('isActive', $status);
        }

        if (!empty($account_type)) {
            $filteredUsers->where('account_type', '=', $account_type);
        }

        $users = $filteredUsers->paginate(20);

        return view('pages.admin.listOfUsers', compact('users', 'uniqueRoles', 'filterUsers'));
    }

    public function searchUser(Request $request)
    {
        $search_text = $request->input('search');
        $sortOrder = 'asc';
        $filterUsers = User::all();
        $uniqueRoles = $filterUsers->flatMap(function ($user) {
            return $user->roles;
        })->unique('id');

        $filterUsers = user::all();
        $users = User::where('id_number', 'LIKE', '%' . $search_text . '%')
            ->orWhere('first_name', 'LIKE', '%' . $search_text . '%')
            ->orWhere('last_name', 'LIKE', '%' . $search_text . '%')
            ->orWhere('account_type', 'LIKE', '%' . $search_text . '%')
            ->paginate(20);

        return view('pages.admin.listOfUsers', compact('users', 'uniqueRoles', 'filterUsers'));
    }

    public function viewUserInfo($id_number)
    {
        $user = User::find($id_number);
        $terms = Term::all();
        return view('pages.admin.viewUserInfo')->with(compact('user','terms'));
    }

    public function addUser()
    {
        $securityQuestions = SecurityQuestion::all();
        $roles = Role::all();

        if (Auth::user()->roles->contains('name', 'manager')) {

            $department = Auth::user()->departments->first();
            $user_college_id = $department->college_id;

            $departments = Department::with('college')->where('college_id', $user_college_id)->get();
            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });

            return view('pages.admin.addUser')->with(compact('departments', 'roles'));
        } else if (Auth::user()->roles->contains('name', 'admin')) {
            $departments = Department::with('college')->get();

            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });
            return view('pages.admin.addUser')->with(compact('departments', 'roles'));
        }
    }

    public function uploadCSVFile()
    {
        if (Auth::user()->roles->contains('name', 'manager')) {
            $department = Auth::user()->departments->first();
            $user_college_id = $department->college_id;

            $departments = Department::with('college')->where('college_id', $user_college_id)->get();
            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });
        } else if ((Auth::user()->roles->contains('name', 'admin'))) {
            $departments = Department::with('college')->get();

            $departments->each(function ($department) {
                $department->college_name = $department->college->college_name;
            });
        }
        return view('pages.admin.uploadCSV')->with(compact('departments'));
    }

    public function storeCSVFile(Request $request)
    {

        dd($request->file('csv_file')->get());
        // return view('pages.admin.uploadCSV');
    }

    // public function saveNewUser(Request $request)
    // {
    //     dd($request);
    //     $password = Str::random(7);
    //     $role_ids = $request->input('role_id');
    //     $department_ids = $request->input('department_ids', []);

    //     $this->validate(
    //         $request,
    //         [
    //             'id_number' => 'required|unique:users,id_number',
    //             'first_name' => 'required',
    //             'last_name' => 'required',
    //             'account_type' => 'required',
    //             // 'email' => 'required',
    //         ]
    //     );

    //     $user = User::where('id_number', '=', $request->input('id_number'))->first();
    //     if ($user === null) {
    //         $user = User::create([
    //             'id_number' => $request->id_number,
    //             'first_name' => $request->first_name,
    //             'last_name' => $request->last_name,
    //             'email' => $request->email,
    //             'isActive' => true,
    //             'account_type' => $request->account_type,
    //             'password' => Hash::make($password),
    //             'password_updated' => 0,
    //         ]);

    //         foreach ($department_ids as $department_id) {
    //             UserDepartment::create([
    //                 'user_id_number' => $request->id_number,
    //                 'department_id' => $department_id
    //             ]);
    //         }

    //         foreach ($role_ids as $role_id) {
    //             UserRole::create([
    //                 'user_id_number' => $request->id_number,
    //                 'role_id' => $role_id,
    //             ]);
    //         }

    //         dispatch(new SendTemporaryPasswordEmailJob($user, $password));
    //         // Session::flash('success', 'User Successfully Added. Do you want to add another user?');
    //         return response()->json(['success' => true], 200);
    //         // return redirect('add-new-user');
    //     } else {
    //         // Session::flash('danger', 'I.D. Number has already been used.');
    //         // return redirect('add-new-user');
    //         return response()->json(['error' => 'I.D. Number has already been used.'], 409);
    //     }

    // }
    public function saveNewUser(Request $request)
    {
        $activeTerm = Term::where('isCurrent', true)->first();
        $termId = $activeTerm->id;
        $password = Str::random(7);
        $role_ids = $request->input('role_id');
        $department_ids = $request->input('department_ids', []);
        $user = User::where('id_number', $request->input('id_number'))->first();

        if ($role_ids == null) {
            return response()->json(['emptyRole' => 'Please select a role.']);
        }

        if ($request->input('account_type') == null) {
            return response()->json(['emptyAccountType' => 'Please select a account type.']);
        }

        if($user){
            return response()->json(['duplicate' => 'I.D. Number has already been used.']);
        }

        $this->validate($request, [
            'id_number' => 'required|unique:users,id_number',
            'first_name' => 'required',
            'last_name' => 'required',
            'account_type' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($user === null) {
            $user = User::create([
                'id_number' => $request->id_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email, 
                'isActive' => true,
                'account_type' => $request->account_type,
                'password' => Hash::make($password),
                'password_updated' => false,
                'isAgreed' => false,
                'term_id' => $termId
            ]);

            foreach ($department_ids as $department_id) {
                UserDepartment::create([
                    'user_id_number' => $request->id_number,
                    'department_id' => $department_id
                ]);
            }

            foreach ($role_ids as $role_id) {
                UserRole::create([
                    'user_id_number' => $request->id_number,
                    'role_id' => $role_id,
                ]);
            }

            dispatch(new SendTemporaryPasswordEmailJob($user, $password));

            return response()->json(['success' => true], 200);
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
        $roles = Role::all();
        $departments = Department::with('college')->get();

        $departments->each(function ($department) {
            $department->college_name = $department->college->college_name;
        });


        return view('pages.admin.editUserInfo')->with(compact('user', 'departments', 'roles'));
    }

    public function saveEditedUserInfo(Request $request, $id_number)
    {
        $user = User::find($id_number);
        $user->id_number = $request->id_number;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->account_type = $request->account_type;
        $user->isActive = $request->isActive;
        $user->email = $request->email;
        $user->update();

        $new_role_ids = $request->input('role_id', []);
        $new_role_id = isset($new_role_ids[0]) ? $new_role_ids[0] : null;
        $current_user_role = UserRole::where('user_id_number', $id_number)->first();

        if (!$current_user_role) {
            UserRole::create([
                'user_id_number' => $request->id_number,
                'role_id' => $new_role_id,
            ]);
        } else {
            if ($current_user_role->role_id !== $new_role_id) {
                $current_user_role->update(['role_id' => $new_role_id]);
            }
        }

        if ($new_role_id == 3) {
            $user->departments()->detach();
        } elseif ($new_role_id == 2) {
            $department_ids = $request->input('department_ids', []);
            $user->departments()->sync($department_ids);
        }

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
        if ($id_number == Auth::user()->id_number) {

            $request->validate([
                'new_password' => 'required|min:7',
                'password_confirmation' => ['same:new_password'],
            ]);
            User::find($id_number)->update(['password' => Hash::make($request->new_password)]);

            $user = User::find($id_number);

            if ($user->password_updated == false) {
                User::find($id_number)->update(['password_updated' => true]);
            }

            if (Auth::user()->security_question_id == null || '') {
                $securityQuestions = SecurityQuestion::all();
                Session::flash('password_updated', 'Your password has been updated sucessfully.');
                return view('pages.auth.setupSecurityQuestion')->with('securityQuestions', $securityQuestions);
            } else {
                return redirect('/')->with('message', 'Password changed successfully. Please login with new password.');
            }
        } else {
            try {
                $request->validate([
                    'new_password' => 'required|min:7',
                    'password_confirmation' => ['same:new_password'],
                ]);

                User::find($id_number)->update(['password' => Hash::make($request->new_password)]);

                Session::flash('success', 'User ' . $id_number . ' password has been changed.');
                return redirect('list-of-users');
            } catch (\Throwable $th) {

                Session::flash('danger', 'Password invalid or password confirmation did not match for user ' . $id_number . '.');
                return redirect('list-of-users');
            }
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
            'email' => $request->email,
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

        return redirect('profile-' . $id_number . '')->with('success', 'Security Question Updated Sucessfully.');
    }
}
