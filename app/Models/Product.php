<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    // Gunakan soft delete (produk tidak dihapus permanen dari database)
    use SoftDeletes;

    // Kolom-kolom yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'is_visible',
        'image_url',
        'category_id',
        'shopee_url',    // URL ke Shopee
        'tiktok_url',    // URL ke TikTok Shop
    ];

    // Relasi satu produk bisa memiliki banyak bookmark
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Relasi produk bisa di-bookmark oleh banyak user (many-to-many)
    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    // Relasi produk bisa memiliki banyak kategori (many-to-many)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    // Relasi produk bisa memiliki banyak review
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Event lifecycle model (boot method)
    protected static function booted()
    {
        // Saat produk dihapus, hapus juga file gambarnya dari storage
        static::deleting(function ($product) {
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
        });

        // Saat gambar diubah, hapus gambar lama dari storage
        static::updating(function ($product) {
            if ($product->isDirty('image_url')) {
                $original = $product->getOriginal('image_url');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }
        });
    }
}
