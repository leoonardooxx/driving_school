<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCategory extends Model
{
     protected $fillable = [
        'user_id',
        'category_id',
        'end_date',
        'status',
     ];
}
