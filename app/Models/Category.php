<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    // Kolom-kolom yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_url',
        'is_active',
        'order_column'
    ];

    // Casting atribut is_active menjadi boolean
    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relasi many-to-many dengan model Product melalui tabel pivot category_product
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}
