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
        'item_category',
        'brand',
        'model',
        'description',
        'quantity',
        'aquisition_date',
        'status',
        'borrowed',
        'inventory_tag',
        'serial_number',
        'same_serial_numbers'
    ];

    public function room(): HasOne
    {
        return $this->HasOne(Room::class, 'id', 'location');
    }
}
