<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(User::class, 'role_permission', 'role_id', 'permission_id');
    }
}
