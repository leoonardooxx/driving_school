<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'quantity',
        'payed_date',
        'expiration_date',
        'status',
        'reference',
        'notes',
        'user_id'
    ];
}
