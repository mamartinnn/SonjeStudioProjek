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

    // Kolom-kolom yang bisa diisi secara massal
    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_admin',
    ];

    // Kolom yang disembunyikan saat model di-serialize (misal dikirim ke frontend)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting atribut ke tipe data tertentu
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // konversi ke objek DateTime
            'password' => 'hashed', // hash otomatis saat diset
        ];
    }

    // Mengecek apakah user memiliki peran admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relasi: user memiliki banyak bookmark
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    // Relasi: user membookmark banyak produk (many-to-many melalui tabel bookmarks)
    public function bookmarkedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'bookmarks');
    }

    // Relasi: user memberikan banyak review
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
