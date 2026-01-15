<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    protected $fillable = [
        'name',
        'description',
        'preview_image',
        'structure',
        'default_styles',
        'is_active',
    ];

    protected $casts = [
        'structure' => 'array',
        'default_styles' => 'array',
        'is_active' => 'boolean',
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
