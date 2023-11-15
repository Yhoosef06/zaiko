<?php

namespace App\Jobs;

use App\Imports\CsvImport;
use Illuminate\Bus\Queueable;
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
    protected $departmentIds;
    public function __construct($filePath, $departmentIds)
    {
        $this->filePath = $filePath;
        $this->departmentIds = $departmentIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(120);
        Excel::import(new CsvImport($this->departmentIds), $this->filePath);
    }
}
