<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $table = 'agreements';
    protected $fillable = ['agreement_text'];
    public $timestamps = true;
}
