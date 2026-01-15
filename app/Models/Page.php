<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'title',
        'slug',
        'description',
        'meta_tags',
        'styles',
        'scripts',
        'is_published',
        'domain',
    ];

    protected $casts = [
        'meta_tags' => 'array',
        'styles' => 'array',
        'scripts' => 'array',
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function components(): HasMany
    {
        return $this->hasMany(PageComponent::class)->orderBy('order');
    }

    public function getUrlAttribute(): string
    {
        return $this->domain ?? route('page.show', $this->slug);
    }
}
