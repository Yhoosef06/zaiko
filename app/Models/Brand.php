<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name'
    ];

    public function models(): HasMany
    {
        return $this->hasMany(Models::class, 'brand_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'brand_id' ,'id');
    }
}
