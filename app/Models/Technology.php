<?php
// app/Models/Technology.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'logo'];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}