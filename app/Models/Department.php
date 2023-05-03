<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
        'college_id'
    ];

    public function colleges(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Rooms::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
