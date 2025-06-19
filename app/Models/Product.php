<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
class Product extends Model
{
    
 use SoftDeletes;
   protected $fillable = [
    'name',
    'slug',
    'description',
    'price',
    'stock_quantity',
    'is_visible',
    'image_url',
    'category_id',
    'shopee_url',       // Tambahan
    'tiktok_url',       // Tambahan
];


    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
        
    }

   public function categories()
{
    return $this->belongsToMany(Category::class, 'category_product');
}


    public function reviews(): HasMany
    {
         return $this->hasMany(Review::class);
}

 protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
        });

        static::updating(function ($product) {
            // if the image is being changed, delete the old one
            if ($product->isDirty('image_url')) {
                $original = $product->getOriginal('image_url');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }
        });
    }
}




