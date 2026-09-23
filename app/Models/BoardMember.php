<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    protected $fillable = [
        'name_en',
        'name_bn',
        'designation_en',
        'designation_bn',
        'type',
        'phone',
        'email',
        'bio_en',
        'bio_bn',
        'image',
        'social_facebook',
        'social_linkedin',
        'social_twitter',
        'social_instagram',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get associative array of social media links
     */
    public function getSocialLinksAttribute(): array
    {
        return [
            'facebook' => $this->social_facebook ?: '',
            'linkedin' => $this->social_linkedin ?: '',
            'twitter' => $this->social_twitter ?: '',
            'instagram' => $this->social_instagram ?: '',
        ];
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->name_en ?: $this->name_bn) : ($this->name_bn ?: $this->name_en);
    }

    public function getDesignationAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->designation_en ?: $this->designation_bn) : ($this->designation_bn ?: $this->designation_en);
    }

    public function getBioAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->bio_en ?: $this->bio_bn) : ($this->bio_bn ?: $this->bio_en);
    }

    /**
     * Get image URL with vector placeholder fallback
     */
    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            $cleaned = ltrim($this->image, '/');
            if (file_exists(public_path($cleaned))) {
                return asset($cleaned);
            }
        }

        return asset('images/avatar-placeholder.png');
    }

    /**
     * Scope for active members
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for chairman
     */
    public function scopeChairman($query)
    {
        return $query->where('type', 'chairman');
    }

    /**
     * Scope for board of directors
     */
    public function scopeDirectors($query)
    {
        return $query->where('type', 'director');
    }

    /**
     * Scope for advisory council
     */
    public function scopeAdvisors($query)
    {
        return $query->where('type', 'advisor');
    }
}
