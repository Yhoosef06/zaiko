<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'item_id',
        'quantity',
        'mode',
        'date',
        'encoded_by'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_number', 'encoded_by');
    }

    public function roomFrom(): HasOne
    {
        return $this->hasOne(Room::class, 'id', 'room_from');
    }

    public function roomTo(): HasOne
    {
        return $this->hasOne(Room::class, 'id', 'room_to');
    }
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}


