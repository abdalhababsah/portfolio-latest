<?php
// app/Models/Education.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'institution_en', 'institution_ar',
        'degree_en', 'degree_ar',
        'start_date', 'end_date',
        'description_en', 'description_ar',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}