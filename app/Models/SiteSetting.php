<?php
// app/Models/SiteSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key_name', 'value_en', 'value_ar','about_me_en','about_me_ar','profile_image'
    ];

    public $timestamps = false;
}