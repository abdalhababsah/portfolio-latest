<?php
// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'slug', 'title_en', 'title_ar',
        'description_en', 'description_ar',
        'price', 'currency', 'unit_en', 'unit_ar',
        'cover_image',
        'meta_title_en', 'meta_title_ar',
        'meta_description_en', 'meta_description_ar',
        'meta_keywords_en', 'meta_keywords_ar',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class);
    }
}