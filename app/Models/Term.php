<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'semester',
        'start_date',
        'end_date',
        'isCurrent'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }
}
