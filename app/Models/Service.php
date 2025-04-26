<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'title_en', 'title_ar',
        'description_en', 'description_ar',
        'price', 'currency',
        'unit_en', 'unit_ar',
        'cover_image',
        'meta_title_en', 'meta_title_ar',
        'meta_description_en', 'meta_description_ar',
        'meta_keywords_en', 'meta_keywords_ar',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title_en);
            }
        });
    }

    /**
     * Get the images for the service.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class);
    }

    /**
     * Get the main images for the service.
     */
    public function mainImage()
    {
        return $this->hasOne(ServiceImage::class)->where('is_main', true);
    }

    /**
     * Get formatted price with currency.
     */
    public function getFormattedPriceAttribute(): string
    {
        return "{$this->price} {$this->currency}";
    }

    /**
     * Get title based on locale.
     */
    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    /**
     * Get description based on locale.
     */
    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    /**
     * Get unit based on locale.
     */
    public function getUnitAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->unit_ar : $this->unit_en;
    }
}