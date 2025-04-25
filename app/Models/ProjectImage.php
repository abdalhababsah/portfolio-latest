<?php
// app/Models/ProjectImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id', 'image_path',
        'alt_text_en', 'alt_text_ar', 'is_main',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}