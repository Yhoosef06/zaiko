<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    // protected $primaryKey = 'serial_number';

    // public $incrementing = false;

    protected $fillable = [
        'id',
        'location',
        'category_id',
        'brand',
        'model',
        'description',
        'quantity',
        'unit_number',
        'aquisition_date',
        'status',
        'borrowed',
        'inventory_tag',
        'serial_number',
        'department_id'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function category(){
        return $this->belongsTo(ItemCategory::class);
    }
}
