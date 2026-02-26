<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name',
        'description',
        'image',
        'price',
        'stock',
        'size',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

     // opsional: format rupiah
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // opsional: status stok
    public function getIsInStockAttribute()
    {
        return (int) $this->stock > 0;
    }

}
