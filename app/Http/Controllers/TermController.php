<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::all();

        return view('pages.admin.listOfTerms')->with(compact('terms'));
    }

    public function addTerm()
    {
        return view('pages.admin.addTerm');
    }

    public function saveNewTerm(Request $request)
    {
        try {
            // $this->validate(
            //     $request,
            //     [
            //         'brand_name' => 'required|unique:brands,brand_name',
            //     ],
            // );

            Term::create([
                'semester' => $request->semester,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'isCurrent' => $request->isCurrent
            ]);
            return redirect()->route('view_terms')->with('success', 'Term added successfully!');
        } catch (\Exception $e) {

            return redirect()->route('view_termss')->with('danger', 'An error occurred while adding the term.');
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
                Session::flash('danger', 'Cannot remove brand because it is referenced by other records.');
            } else {
                Session::flash('danger', 'An error occurred.');
            }
            return redirect('terms');
        }
    }
}
