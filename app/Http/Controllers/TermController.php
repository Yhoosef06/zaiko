<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::all();
        $currentTerm = Term::where('isCurrent', true)->first();
        return view('pages.admin.listOfTerms', ['currentTermId' => $currentTerm ? $currentTerm->id : null])->with(compact('terms'));

    }

    public function addTerm()
    {
        return view('pages.admin.addTerm');
    }

    public function saveNewTerm(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'semester' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ],
            );

            Term::create([
                'semester' => $request->semester,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            return response()->json(['success' => true, 'message' => 'Term added successfully']);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['success' => false, 'message' => 'An error occurred while adding the term']);
        }
    }
    public function deleteTerm($id)
    {
        try {
            $term = Term::find($id);
            $term->delete();

            return response()->json(['success' => true, 'message' => 'Term Successfully Removed']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the term']);
        }
    }

    public function currentTerm(Request $request, $id)
    {
        $termId = $request->input('termId');
        Term::where('id', '<>', $termId)->update(['isCurrent' => false]);
        Term::where('id', $termId)->update(['isCurrent' => true]);
        return response()->json(['message' => 'Current Term Changed.']);
    }
}
