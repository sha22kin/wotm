<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
    ];

    /**
     * Get a setting by key, with optional default value
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, mixed $value, string $group = 'general'): static
    {
        Cache::forget("setting_{$key}");
        Cache::forget('all_settings_grouped');

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    /**
     * Get all settings grouped
     */
    public static function getAllGrouped(): array
    {
        return Cache::remember('all_settings_grouped', 3600, function () {
            $settings = static::all();
            $grouped = [];
            foreach ($settings as $setting) {
                $grouped[$setting->key] = $setting->value;
            }
            return $grouped;
        });
    }

    /**
     * Get reliable URL for setting images (site_logo, footer_logo, site_favicon, seo_og_image)
     */
    public static function getImageUrl(string $key, string $default = ''): string
    {
        $val = static::get($key, $default);
        if (empty($val)) {
            return !empty($default) ? asset($default) : '';
        }

        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }

        $cleanPath = ltrim($val, '/');

        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        if (file_exists(public_path('images/' . $cleanPath))) {
            return asset('images/' . $cleanPath);
        }

        if (file_exists(public_path('storage/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        $storageSub = preg_replace('#^storage/#', '', $cleanPath);
        if (file_exists(storage_path('app/public/' . $storageSub))) {
            return asset(str_starts_with($cleanPath, 'storage/') ? $cleanPath : 'storage/' . $cleanPath);
        }

        return asset($cleanPath);
    }
}
