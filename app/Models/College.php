<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class College extends Model
{
    use HasFactory;
    protected $fillable = [
        'college_name',
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}
