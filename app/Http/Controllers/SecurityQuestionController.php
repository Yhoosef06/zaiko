<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SecurityQuestion;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityQuestionController extends Controller
{
    public function getIdNumber()
    {
        $id_number = 1;
        return view('pages.auth.getIdNumber', compact('id_number'));
    }

    public function securityQuestion(Request $request)
    {

        $id_number = $request->input('id_number');

        $request->validate([
            'id_number' => 'required',
        ]);

        $user = User::where('id_number', $id_number)->first();

        if ($user) {
            $securityQuestions = SecurityQuestion::all();
            return view('pages.auth.securityQuestion')->with(compact('securityQuestions', 'id_number'));
        } else {
            return redirect()->back()->with(['message' => 'Invalid I.D. Number.']);
        }

        return view('pages.auth.securityQuestion')->with(compact('securityQuestions'));
    }

    public function verifySecurityQuestion(Request $request, $id_number)
    {

        $idNumber = $id_number;
        $questionId = $request->input('question');
        $answer = $request->input('answer');

        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        // Query the database
        $user = User::where('id_number', $idNumber)->first();

        if ($user) {
            if ($user->security_question_id == $questionId && $user->answer == $answer) {
                return view('pages.auth.passwordReset')->with(compact('id_number'));
            } else {
                return redirect()->back()->with('message', 'Invalid security question or answer.');
            }
        }
    }

    public function resetPassword(Request $request, $id_number)
    {
        $request->validate([
            'new_password' => 'required|min:7',
            'password_confirmation' => ['same:new_password'],
        ]);

        User::find($id_number)->update(['password' => Hash::make($request->new_password)]);

        return view('pages.auth.passwordResetSucessfully');
    }

    public function setupSecurityQuestion(Request $request, $id_number)
    {
        $securityQuestions = SecurityQuestion::all();
        return view('pages.auth.setupSecurityQuestion')->with(compact('securityQuestions'));
    }

    public function storeSecurityQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required|exists:security_questions,id',
            'answer' => 'required|string',
        ]);

        User::find(Auth::user()->id_number)->update([
            'security_question_id' => $request->question,
            'answer' => $request->answer
        ]);

        $userRoles = Auth::user()->roles;

        $userRole = $userRoles->pluck('name')->first();

        if ($userRole == 'borrower') {
            return redirect()->route('student.dashboard')->with('success', 'Security Settings Updated Successfully.');
        } else if ($userRole == 'manager') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('admin.dashboard')->with('success', 'Security Settings Updated Successfully.');
        }
    }
}
