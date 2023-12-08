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

            $import = new CsvImport();
            Excel::import($import, $filePath);

            $importErrors = $import->getErrors();

            if (!empty($importErrors)) {
                return response()->json(['error' => 'Error during CSV file upload.', 'errors' => $importErrors], 422);
            }

            return response()->json(['success' => 'CSV file uploaded successfully!']);
        } catch (ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure->row() . ', Column ' . $failure->attribute() . ': ' . $failure->errors()[0];
            }

            if (!empty($errorMessages)) {
                return response()->json(['error' => 'Error during CSV file upload.', 'errors' => $errorMessages], 422);
            } else {
                return response()->json(['error' => 'Error during CSV file upload.'], 422);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error during CSV file upload.', 'exception' => $th->getMessage()], 500);
        }
    }
}