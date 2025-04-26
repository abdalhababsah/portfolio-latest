<?php
// app/Models/SiteSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key_name', 'value_en', 'value_ar',
    ];
    
    // Add attributes specific to the provided fields
    protected function getProfileImageAttribute()
    {
        if ($this->key_name === 'profile_image') {
            return $this->value_en;
        }
        return null;
    }
    
    protected function getAboutMeEnAttribute()
    {
        if ($this->key_name === 'about_me') {
            return $this->value_en;
        }
        return null;
    }
    
    protected function getAboutMeArAttribute()
    {
        if ($this->key_name === 'about_me') {
            return $this->value_ar;
        }
        return null;
    }
    
    protected function getEmailAttribute()
    {
        if ($this->key_name === 'email') {
            return $this->value_en;
        }
        return null;
    }
    
    protected function getHeroHeadingEnAttribute()
    {
        if ($this->key_name === 'hero_heading') {
            return $this->value_en;
        }
        return null;
    }
    
    protected function getHeroHeadingArAttribute()
    {
        if ($this->key_name === 'hero_heading') {
            return $this->value_ar;
        }
        return null;
    }
    
    protected function getHeroTaglineEnAttribute()
    {
        if ($this->key_name === 'hero_tagline') {
            return $this->value_en;
        }
        return null;
    }
    
    protected function getHeroTaglineArAttribute()
    {
        if ($this->key_name === 'hero_tagline') {
            return $this->value_ar;
        }
        return null;
    }
    
    protected function getSiteTitleEnAttribute()
    {
        if ($this->key_name === 'site_title') {
            return $this->value_en;
        }
        return null;
    }
    
    protected function getSiteTitleArAttribute()
    {
        if ($this->key_name === 'site_title') {
            return $this->value_ar;
        }
        return null;
    }
    
    protected function getCvUrlAttribute()
    {
        if ($this->key_name === 'cv_url') {
            return $this->value_en;
        }
        return null;
    }
    
    // Helper method to get a setting by key
    public static function getSetting($key, $locale = null)
    {
        $setting = self::where('key_name', $key)->first();
        
        if (!$setting) {
            return null;
        }
        
        if ($locale === 'ar') {
            return $setting->value_ar ?: $setting->value_en;
        }
        
        return $setting->value_en;
    }
}