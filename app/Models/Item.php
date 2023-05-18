<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function room(): HasOne
    {
        return $this->HasOne(Room::class, 'id', 'location');
    }

    public function category(){
        return $this->belongsTo(ItemCategory::class);
    }
}
