<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceImage extends Model
{
    protected $fillable = [
        'service_id',
        'image_path',
        'alt_text_en',
        'alt_text_ar',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    /**
     * Get the service that owns the image.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get alt text based on current locale.
     */
    public function getAltTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->alt_text_ar : $this->alt_text_en;
    }
}