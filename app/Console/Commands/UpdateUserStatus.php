<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the isActive column in Users table.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('isActive', true)->get();

        foreach ($users as $user) {
            $activeTerm = $user->activeTerm();

            $isBorrower = $user->roles()->where('role_id', 3)->exists();

            if (($activeTerm === null || now()->isAfter($activeTerm->end_date)) && $isBorrower) {
                $user->update(['isActive' => false]);
            }
        }

        $this->info('User statuses updated successfully.');
    }

}
