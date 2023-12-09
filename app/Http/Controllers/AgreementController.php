<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgreementController extends Controller
{
    public function index()
    {
        $agreement = Agreement::find(1);
        return view('pages.admin.agreementForm')->with(compact('agreement'));
    }

    public function store(Request $request)
    {
        $agreementText = $request->input('agreement_text');
        $agreement = Agreement::firstOrNew(['id' => 1]); 
        $agreement->agreement_text = $agreementText;
        $agreement->save();
    
        return response()->json(['success' => true, 'message' => 'Agreement updated successfully']);
    }

    public function show()
    {
        $agreement = Agreement::find(1);
        return view('pages.admin.agreement')->with(compact('agreement'));
    }

    public function agreed()
    {
        Auth::user()->update([
            'isAgreed' => true,
        ]);

        return redirect()->route('borrower.dashboard');
    }
    
}
