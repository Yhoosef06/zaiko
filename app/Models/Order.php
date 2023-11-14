<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_submitted',
        'date_returned',
        'created_by',
        'approval_date',
        'approved_by',
        'order_status'
    ];

    public function orderItemTemp(): HasMany
    {
        return $this->hasMany(OrderItemTemp::class);
    }

    public function order_item(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
