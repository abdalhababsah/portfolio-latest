<?php
// app/Models/ServiceImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceImage extends Model
{
    protected $fillable = [
        'service_id', 'image_path',
        'alt_text_en', 'alt_text_ar', 'is_main',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}