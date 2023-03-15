<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'serial_number';

    public $incrementing = false;

    protected $fillable = [
        'serial_number',
        'item_name',
        'item_description',
        'quantity',
        'unit_number',
        'aquisition_date',
        'status',
        'borrowed',
        'inventory_tag',
        'location'
    ];
}
