<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SecurityQuestion;

class SecurityQuestionController extends Controller
{
    public function index()
    {
        $securityQuestions = SecurityQuestion::all();

        return view('pages.securityQuestion')->with(compact('securityQuestions'));
    }

    public function verify(Request $request)
    {
        $idNumber = $request->input('id_number');
        $questionId = $request->input('question');
        $answer = $request->input('answer');

        $request->validate([
            'id_number' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);

        // Query the database
        $user = User::where('id_number', $idNumber)->first();

        if ($user) {
            if ($user->security_question_id == $questionId && $user->answer == $answer) {
              dd('change pass here');
            } else {
                return redirect()->back()->with('message', 'Invalid security question or answer.');
            }
        } else {
            return redirect()->back()->with(['message' => 'User not found.']);
        }
    }
}
