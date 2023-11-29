<?php

namespace App\Http\Controllers;

use App\Imports\CsvImport;
use App\Jobs\CsvImportJob;
use App\Models\Term;
use Illuminate\Http\Request;
use App\Mail\TemporaryPasswordEmail;
use Maatwebsite\Excel\Facades\Excel;

class CsvController extends Controller
{
    public function store(Request $request)
    {
        $term = Term::where('isCurrent', true)->count() === 0;
        if ($term) {
            return redirect()->back()->with('danger', 'Please setup a school term first.');
        }
        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt|max:2048',
               
            ]);

            $file = $request->file('csv_file');
            $filePath = $file->getRealPath();

            Excel::import(new CsvImport,  $filePath);

            return redirect()->back()->with('success', 'CSV file uploaded successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', 'Error during CSV file upload.');
        }

    }
}