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
        // Fetch the current term from the database
        $currentTerm = Term::where('isCurrent', true)->first();

        // Pass the current term ID to the Blade template
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
            return redirect()->route('view_terms')->with('success', 'Term added successfully!');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->route('view_terms')->with('danger', 'An error occurred while adding the term.');
        }
    }

    public function deleteTerm($id)
    {
        try {
            $term = Term::find($id);
            $term->delete();

            Session::flash('success', 'Term Successfully Removed');
            return redirect('terms');
        } catch (QueryException $e) {
            // Check if the exception is due to a foreign key constraint violation
            if ($e->getCode() === '23000') {
                Session::flash('danger', 'Cannot remove term because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('terms');
        }
    }

    public function currentTerm(Request $request, $id)
    {
        $termId = $request->input('termId');

        // Set all terms to 'isCurrent' = false except the selected one
        Term::where('id', '<>', $termId)->update(['isCurrent' => false]);

        // Set the selected term as the current term
        Term::where('id', $termId)->update(['isCurrent' => true]);

        // Return a response if needed
        return response()->json(['message' => 'Term updated successfully']);
    }
}
