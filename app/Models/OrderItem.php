<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_temp_id',
        'user_id',
        'order_id',
        'item_id',
        'quantity',
        'status',
        'remarks',
        'order_serial_number',
        'date_returned',
        'returned_to',
        'released_by'
    ];

    public function order_item(): BelongsTo {
        return $this->belongsTo(OrderItemTemp::class);
    }
    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
    
    public function item_mode(): BelongsToMany
    {
        return $this->belongsToMany(ItemMode::class);
    }
}
