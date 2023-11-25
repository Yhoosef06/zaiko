<?php

namespace App\Jobs;

use Exception;
use App\Imports\CsvImport;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CsvImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $filePath;
    // protected $departmentIds;
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        // $this->departmentIds = $departmentIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    // public function handle()
    // {
    //     set_time_limit(180);
    //     Excel::import(new CsvImport, $this->filePath);
    // }

    public function handle()
    {
        try {
            set_time_limit(0);
            Excel::import(new CsvImport, $this->filePath);

            Log::info('CSV file imported successfully.');
        } catch (Exception $e) {
            Log::error('Error during CSV import: ' . $e->getMessage());
            throw $e;
        }
    }
}
