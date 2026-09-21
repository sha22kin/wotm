<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    protected $fillable = [
        'name_en',
        'name_bn',
        'slug',
        'order',
        'is_active',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class, 'gallery_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(GalleryItem::class, 'gallery_category_id')->where('type', 'image');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(GalleryItem::class, 'gallery_category_id')->where('type', 'video');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->name_en ?: $this->name_bn) : ($this->name_bn ?: $this->name_en);
    }
}
