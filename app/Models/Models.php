<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Models extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'model_name',
        'brand_id'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(brand::class, 'brand_id');
    }
}
