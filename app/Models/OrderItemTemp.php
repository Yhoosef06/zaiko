<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItemTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_id',
        'temp_serial_number',
        'temp_duration',
        'quantity',
    ];

    public function order_item(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
