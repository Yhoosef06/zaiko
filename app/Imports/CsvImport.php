<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\UserDepartment;
use App\Mail\TemporaryPasswordEmail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;

class CsvImport implements ToModel
{   
    protected $departmentIds;

    public function __construct($departmentIds)
    {
        $this->departmentIds = $departmentIds;
    }
    public static $user; // Add this property
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
            'password_updated' => 0,
        ]);
        try {
            $user->save();
            $user->roles()->attach($role);

            foreach ($this->departmentIds as $departmentId) {
                UserDepartment::create([
                    'user_id_number' => $user->id_number,
                    'department_id' => $departmentId,
                ]);
            }

            Mail::to($user->email)->send(new TemporaryPasswordEmail($user, $password));

            return $user;
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., log the error)
            // \Log::error($e);
            dd($e);
            // Optionally, you might want to throw the exception again to let the job fail and retry
            // throw $e;

            return null; // or handle the error in a way that suits your application
        }
    }

}
