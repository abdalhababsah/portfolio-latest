<?php
// app/Models/Skill.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = [
        'name_en', 'name_ar',
        'description_en', 'description_ar',
        'level', 'category_id', 'icon',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}