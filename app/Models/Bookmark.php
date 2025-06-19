<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    // Menentukan kolom yang boleh diisi secara massal
    protected $fillable = ['user_id', 'product_id'];

    // Relasi bookmark dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi bookmark dimiliki oleh satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
