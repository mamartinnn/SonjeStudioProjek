<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model 
{
    

    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'image_url',
        'is_active',
        'order_column'
    ];

  

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products(): BelongsToMany
{
    return $this->belongsToMany(Product::class, 'category_product');
}   
}