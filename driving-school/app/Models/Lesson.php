<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
        protected $fillable = [
        'start_date',
        'end_date',
        'type',
        'instructor_id',
        'vehicle_id'
    ];
}
