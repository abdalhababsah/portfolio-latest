<?php
// app/Models/Certificate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'title_en', 'title_ar',
        'description_en', 'description_ar',
        'file_path', 'issued_by',
        'date_issued', 'expiry_date',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'expiry_date' => 'date',
    ];
}