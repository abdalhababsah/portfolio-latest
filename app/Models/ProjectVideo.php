<?php
// app/Models/ProjectVideo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectVideo extends Model
{
    protected $fillable = [
        'project_id', 'video_url',
        'caption_en', 'caption_ar',
        'thumbnail_path', 'thumbnail_alt_en', 'thumbnail_alt_ar',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}