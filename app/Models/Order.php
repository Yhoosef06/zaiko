<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'first_name', 
        'last_name', 
        'category',
        'serial_number', 
        'brand', 
        'model', 
        'item_description',
        'quantity', 
        'return_date', 
        'order_status',
        'release_by',
        'return_to',
        'item_remark'
    ];
}
