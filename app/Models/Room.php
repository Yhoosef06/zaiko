<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'room_name',
        'department_id'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'location');
    }
}
