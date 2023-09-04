<?php

namespace App\Models;

use BaconQrCode\Common\Mode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'available_quantity',
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

    public function category(){
        return $this->belongsTo(ItemCategory::class, 'category_id', 'id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(Models::class, 'model_id', 'id');
    }

    public function order_item_temp(): HasMany
    {
        return $this->hasMany(OrderItemTemp::class);
    }

    public function order_item(): HasMany 
    {
        return $this->hasMany(OrderItem::class);
    }

    public function item_mode(): HasMany 
    {
        return $this->hasMany(ItemMode::class);
    }
}
