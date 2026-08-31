<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorCategory extends Model
{
     protected $fillable = [
        'user_id',
        'category_id',
        'end_date',
        'status',
     ];
}
           