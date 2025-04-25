<?php
// app/Models/Experience.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'company_en', 'company_ar',
        'position_en', 'position_ar',
        'start_date', 'end_date',
        'description_en', 'description_ar',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}