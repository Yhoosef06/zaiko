<?php

namespace App\Imports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User; // Import your model

class CsvImport implements ToModel
{
    public function model(array $row)
    {

        // if ($row[1] === null) {

        //     return null;
        // }

        $role = Role::find(3);

        $idNumber = isset($row[0]) ? $row[0] : null;
        $firstName = isset($row[1]) ? $row[1] : null;
        $lastName = isset($row[2]) ? $row[2] : null;
        $password = isset($row[3]) ? bcrypt($row[3]) : null;
        $accountType = isset($row[4]) ? $row[4] : null;
        $accountStatus = isset($row[5]) ? $row[5] : null;

        $user = new User([
            'id_number' => $idNumber,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => $password,
            'account_type' => $accountType,
            'account_status' => $accountStatus,
        ]);
        $user->save();
        $user->roles()->attach($role);

        return $user;
    }
}
