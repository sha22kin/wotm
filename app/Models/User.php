<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_admin',
        'role',
        'status',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']) || (bool) $this->is_admin;
    }

    public function isEditor(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'editor']);
    }

    public function isModerator(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'moderator']);
    }

    public function getRoleNameAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'editor' => 'Editor / Staff',
            'moderator' => 'Moderator',
            'member' => 'Member / User',
            default => ucfirst(str_replace('_', ' ', $this->role ?: 'member')),
        };
    }

    /**
     * Get reliable URL for user avatar with fallback
     */
    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->avatar)) {
            return asset('images/avatar-default.png');
        }

        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }

        $cleanPath = ltrim($this->avatar, '/');

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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
}
