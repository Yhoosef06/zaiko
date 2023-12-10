<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\Term;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendTemporaryPasswordEmailJob;
use Illuminate\Validation\ValidationException;

class CsvImport implements ToModel
{
    public static $user;
    protected $errors = [];
    public function model(array $row)
    {
        $role = Role::find(3);
        $password = Str::random(7);
        $activeTerm = Term::where('isCurrent', true)->first();
        $termId = $activeTerm->id;
        $accountType = 'student';

        $idNumber = isset($row[0]) ? $row[0] : null;
        $firstName = isset($row[1]) ? $row[1] : null;
        $lastName = isset($row[2]) ? $row[2] : null;
        $email = isset($row[3]) ? $row[3] : null;

        $validator = Validator::make([
            'email' => $email,
            'idNumber' => $idNumber,
        ], [
            'email' => 'required|email|unique:users,email',
            'idNumber' => 'required|unique:users,id_number',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email already exists.',
            'idNumber.required' => 'ID number is required.',
            'idNumber.unique' => 'ID number already exists.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $row[] =  $errors[0]; 
            $this->errors[] = $row;
            return null;
        }

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
                'isAgreed' => false,
                'term_id' => $termId
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->update(['isActive' => true, 'term_id' => $termId]);
        } else {
            $user->save();
            $user->roles()->attach($role);
            dispatch(new SendTemporaryPasswordEmailJob($user, $password));
        }

        return $user;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}