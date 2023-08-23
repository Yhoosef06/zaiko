<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class College extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'college_name',
    ];

    public $incrementing = false;

    protected $primaryKey = 'id';

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'college_id');
    }
}
