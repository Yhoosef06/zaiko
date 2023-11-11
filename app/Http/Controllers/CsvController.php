<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CsvImport; // Import your CSV import class

class CsvController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            ]);

            $file = $request->file('csv_file');

            Excel::import(new CsvImport, $file);

            return redirect()->back()->with('success', 'CSV file uploaded successfully!');
        } catch (\Throwable $th) {

            // dd($th);

            return redirect()->back()->with('danger', 'Error during CSV file upload.');
        }

    }
}
