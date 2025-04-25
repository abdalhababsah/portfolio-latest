<?php
// app/Models/Blog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    protected $fillable = [
        'slug', 'title_en', 'title_ar',
        'summary_en', 'summary_ar',
        'content_en', 'content_ar',
        'cover_image', 'reading_time',
        'meta_title_en', 'meta_title_ar',
        'meta_description_en', 'meta_description_ar',
        'meta_keywords_en', 'meta_keywords_ar',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}