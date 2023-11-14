<?php

namespace App\Http\Controllers;

use App\Imports\CsvImport;
use App\Jobs\CsvImportJob;
use Illuminate\Http\Request;
use App\Mail\TemporaryPasswordEmail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class CsvController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            ]);

            $file = $request->file('csv_file');
            $filePath = $file->getRealPath();
            // Excel::import(new CsvImport, $file);
            dispatch(new CsvImportJob($filePath));

            return redirect()->back()->with('success', 'CSV file uploaded successfully!');
        } catch (\Throwable $th) {

            dd($th);

            return redirect()->back()->with('danger', 'Error during CSV file upload.');
        }

    }
}
