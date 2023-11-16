<?php

namespace App\Imports;

use App\Models\Role;
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

        $idNumber = isset($row[0]) ? $row[0] : null;
        $firstName = isset($row[1]) ? $row[1] : null;
        $lastName = isset($row[2]) ? $row[2] : null;
        // $password = isset($row[3]) ? Str::random(7) : null;
        $accountType = isset($row[4]) ? $row[4] : null;
        $accountStatus = isset($row[5]) ? $row[5] : null;
        $email = isset($row[6]) ? $row[6] : null;

        $user = new User([
            'id_number' => $idNumber,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => bcrypt($password),
            'account_type' => $accountType,
            'account_status' => $accountStatus,
            'email' => $email,
            'isActive' => true,
            'password_updated' => false,
        ]);
        try {

            $user = User::firstOrCreate(
                ['id_number' => $idNumber],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'password' => bcrypt($password),
                    'account_type' => $accountType,
                    'account_status' => $accountStatus,
                    'email' => $email,
                    'isActive' => true,
                    'password_updated' => false,
                ]
            );
    
            if (!$user->wasRecentlyCreated) {
                $user->update(['isActive' => true]);
            } else {
                $user->save();
                $user->roles()->attach($role);
                // dispatch(new SendTemporaryPasswordEmailJob($user, $password));
            }
    
            return $user;

            // foreach ($this->departmentIds as $departmentId) {
            //     UserDepartment::create([
            //         'user_id_number' => $user->id_number,
            //         'department_id' => $departmentId,
            //     ]);
            // }

            // Mail::to($user->email)->send(new TemporaryPasswordEmail($user, $password));
          
        } catch (\Exception $e) {

            dd($e);

            return null;
        }
    }

}
