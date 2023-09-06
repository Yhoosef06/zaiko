<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'item_id',
        'quantity',
        'mode',
        'date'
    ];

    // public function item(): HasOne
    // {
    //     return $this->hasOne(Item::class, 'item_id', 'id');
    // }
}


