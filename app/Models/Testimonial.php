<?php
// app/Models/Testimonial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name', 'role', 'image', 'rating',
        'message_en', 'message_ar', 'date_given',
    ];

    protected $casts = [
        'rating'     => 'integer',
        'date_given' => 'date',
    ];
}