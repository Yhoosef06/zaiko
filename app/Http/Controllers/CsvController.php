<?php

namespace App\Http\Controllers;

use App\Imports\CsvImport;
use App\Jobs\CsvImportJob;
use App\Models\Term;
use Illuminate\Http\Request;
use App\Mail\TemporaryPasswordEmail;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class CsvController extends Controller
{
    public function store(Request $request)
    {
        $term = Term::where('isCurrent', true)->count() === 0;
        if ($term) {
            return response()->json(['error' => 'Please set up a school term first.'], 422);
        }

        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            ]);

            $file = $request->file('csv_file');
            $filePath = $file->getRealPath();

            Excel::import(new CsvImport(), $filePath);

            return response()->json(['success' => 'CSV file uploaded successfully!']);
        } catch (ValidationException $e) {
            // Handle validation errors specifically
            $failures = $e->failures();
            // Process and return specific error messages for validation failures
            return response()->json(['error' => 'Error during CSV file upload.', 'errors' => $failures], 422);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error during CSV file upload.', 'exception' => $th->getMessage()], 500);
        }
    }
}