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

    /**
     * Get reliable, cross-platform URL for the media image or thumbnail poster
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset($this->type === 'video' ? 'images/video-thumb.jpg' : 'images/hero2.webp');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        $cleanPath = ltrim($this->image_path, '/');

        // 1. Direct file in public root (e.g. 7.jpeg, 8.jpeg)
        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        // 2. File in public/images/ (e.g. video-thumb.jpg, hero2.webp)
        if (file_exists(public_path('images/' . $cleanPath))) {
            return asset('images/' . $cleanPath);
        }

        // 3. File in public/storage/ (symlinked or direct)
        if (file_exists(public_path('storage/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        // 4. File stored in storage/app/public/
        $storageSub = preg_replace('#^storage/#', '', $cleanPath);
        if (file_exists(storage_path('app/public/' . $storageSub))) {
            return asset(str_starts_with($cleanPath, 'storage/') ? $cleanPath : 'storage/' . $cleanPath);
        }

        // Default fallback asset helper
        return asset($cleanPath);
    }
}
