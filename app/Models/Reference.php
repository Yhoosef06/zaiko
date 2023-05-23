<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'prepared_by',
        'verified_by',
        'noted_by',
        'approved_by',
        'role_1',
        'role_2',
        'role_3',
        'role_4',
        'location'
    ];

}
