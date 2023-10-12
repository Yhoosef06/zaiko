<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'department_id',
        'user_id_number'
    ];
}
