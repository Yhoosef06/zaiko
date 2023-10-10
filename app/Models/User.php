<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id_number';
    public $incrementing = false;

    protected $fillable = [
        'id_number',
        'first_name',
        'last_name',
        'password',
        'front_of_id',
        'back_of_id',
        'account_type',
        'account_status',
        'role',
        'department_id',
        'security_question_id',
        'answer',
        'last_login_at',
        'password_updated'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function order_item_temp(): HasMany
    {
        return $this->hasMany(OrderItemTemp::class);
    }

    public function order_item(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function securityQuestion()
    {
        return $this->hasOne(SecurityQuestion::class);
    }

    public function itemLog(): HasMany
    {
        return $this->hasMany(ItemLog::class, 'id', 'encoded_by');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id_number', 'role_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_departments', 'user_id_number', 'department_id');
    }

    public function hasPermission($permission)
    {
        // Loop through the user's roles
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }

        return false;
    }
}
