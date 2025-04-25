<?php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'slug', 'title_en', 'title_ar',
        'short_description_en', 'short_description_ar',
        'full_description_en', 'full_description_ar',
        'role_en', 'role_ar',
        'duration_en', 'duration_ar',
        'cover_image', 'featured',
        'category_id', 'github_url', 'demo_url',
        'meta_title_en', 'meta_title_ar',
        'meta_description_en', 'meta_description_ar',
        'meta_keywords_en', 'meta_keywords_ar',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(ProjectVideo::class);
    }
}