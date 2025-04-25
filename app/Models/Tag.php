<?php
// app/Models/Tag.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name_en', 'name_ar'];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class);
    }
}
