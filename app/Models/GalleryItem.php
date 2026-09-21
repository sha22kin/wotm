<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryItem extends Model
{
    protected $fillable = [
        'type', // image or video
        'title_en',
        'title_bn',
        'image_path',
        'video_url',
        'category',
        'gallery_category_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function galleryCategory(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order', 'asc')->latest('id');
    }

    public function scopeImages(Builder $query): Builder
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos(Builder $query): Builder
    {
        return $query->where('type', 'video');
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->title_en ?: $this->title_bn) : ($this->title_bn ?: $this->title_en);
    }

    public function getCategoryNameAttribute(): string
    {
        if ($this->galleryCategory) {
            return $this->galleryCategory->name;
        }

        if ($this->category) {
            return ucfirst($this->category);
        }

        return app()->getLocale() === 'en' ? 'General' : 'সাধারণ';
    }

    public function getCategorySlugAttribute(): string
    {
        if ($this->galleryCategory) {
            return $this->galleryCategory->slug;
        }

        return $this->category ? \Illuminate\Support\Str::slug($this->category) : 'all';
    }
}
