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

    public $timestamps = true;
    // protected $primaryKey = 'serial_number';

    // public $incrementing = false;

    protected $fillable = [
        'id',
        'location',
        'category_id',
        'brand_id',
        'model_id',
        'description',
        'quantity',
        'aquisition_date',
        'status',
        'borrowed',
        'penalty_fee',
        'inventory_tag',
        'serial_number',
        'parent_item',
        'duration',
        'duration_type',
        'replaced_item',
        'part_number',
        'item_image'
    ];

    public function room(): HasOne
    {
        return $this->HasOne(Room::class, 'id', 'location');
    }

    public function category()
    {
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

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class);
    }

    public function itemLogs()
    {
        return $this->hasMany(ItemLog::class, 'item_id');
    }

    public function itemLog()
    {
        return $this->hasOne(ItemLog::class, 'item_id');
    }
}
