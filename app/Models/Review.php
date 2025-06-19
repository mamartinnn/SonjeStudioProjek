<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'is_approved'
    ];

    // Casting tipe data atribut
    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean'
    ];

    // Relasi: review ini dimiliki oleh satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: review ini dimiliki oleh satu produk
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scope untuk mengambil review yang terlihat (jika ada kolom is_visible)
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
