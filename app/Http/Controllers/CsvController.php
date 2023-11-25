<?php

namespace App\Http\Controllers;

use App\Imports\CsvImport;
use App\Jobs\CsvImportJob;
use Illuminate\Http\Request;
use App\Mail\TemporaryPasswordEmail;
use App\Models\UserDepartment;
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

            // dispatch(new CsvImportJob($filePath));
            Excel::import(new CsvImport,  $filePath);

            return redirect()->back()->with('success', 'CSV file uploaded successfully!');
        } catch (\Throwable $th) {

            dd($th);
            return redirect()->back()->with('danger', 'Error during CSV file upload.');
        }

    }
}
 





// dispatch(new CsvImportJob($filePath, $request->input('department_ids')));
 // Excel::import(new CsvImport, $filePath); // 'department_ids' => 'required|array',