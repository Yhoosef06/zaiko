<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\Term;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\UserDepartment;
use App\Mail\TemporaryPasswordEmail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Jobs\SendTemporaryPasswordEmailJob;

class CsvImport implements ToModel
{
    public static $user;
    public function model(array $row)
    {
        $role = Role::find(3);
        $password = Str::random(7);
        $activeTerm = Term::where('isCurrent', true)->first();
        $termId = $activeTerm->id;
        $idNumber = isset($row[0]) ? $row[0] : null;
        $firstName = isset($row[1]) ? $row[1] : null;
        $lastName = isset($row[2]) ? $row[2] : null;
        $accountType = isset($row[4]) ? $row[4] : null;
        $email = isset($row[6]) ? $row[6] : null;

        try {

            $user = User::firstOrCreate(
                ['id_number' => $idNumber],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'password' => bcrypt($password),
                    'account_type' => $accountType,
                    'email' => $email,
                    'isActive' => true,
                    'password_updated' => false,
                    'term_id' => $termId
                ]
            );

            if (!$user->wasRecentlyCreated) {
                $user->update(['isActive' => true, 'term_id' => $termId]);
            } else {
                $user->save();
                $user->roles()->attach($role);
                // dispatch(new SendTemporaryPasswordEmailJob($user, $password));
                // Mail::to($user->email)->send(new TemporaryPasswordEmail($user, $password));
            }
            
            return $user;

            // foreach ($this->departmentIds as $departmentId) {
            //     UserDepartment::create([
            //         'user_id_number' => $user->id_number,
            //         'department_id' => $departmentId,
            //     ]);
            // }
            
            // Mail::to($user->email)->send(new TemporaryPasswordEmail($user, $password));

            // Mail::send(new TemporaryPasswordEmail($user, $password), [], function ($message) use ($user) {
            //     $message->to($user->email);
            // });

        } catch (\Exception $e) {
            return view('pages.admin.uploadCSV')->with('danger', 'No school term is selected.');
        }
    }

}
