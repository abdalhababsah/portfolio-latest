<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name_en', 'name_ar',
        'meta_title_en', 'meta_title_ar',
        'meta_description_en', 'meta_description_ar',
        'meta_keywords_en', 'meta_keywords_ar',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}