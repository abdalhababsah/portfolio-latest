<?php
// app/Models/SocialLink.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = [
        'platform', 'url', 'icon_class',
    ];
}