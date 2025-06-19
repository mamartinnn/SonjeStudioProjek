<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relasi ke tabel bookmarks (model Bookmark)
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    // Relasi ke produk-produk yang dibookmark oleh user ini
    public function bookmarkedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'bookmarks');
    }

    // Relasi ke review
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
