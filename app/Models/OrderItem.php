<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_temp_id',
        'user_id',
        'item_id',
        'quantity',
        'status',
        'remarks',
        'order_serial_number',
        'date_returned',
        'released_by',
        'returned_to'
    ];

    public function orderItem(): BelongsTo {
        return $this->belongsTo(OrderItem::class);
    }
}
