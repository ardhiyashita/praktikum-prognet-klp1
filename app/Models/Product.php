<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guards = [];
    protected $fillable = ['id', 'id_category', 'product_name', 'price', 'description', 'product_rate', 'stock', 'weight'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'id_category', 'id');
    }
}
