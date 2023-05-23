<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'serial_number',
        'item_name',
        'item_description',
        'quantity',
        'ordered'   
    ];
}
