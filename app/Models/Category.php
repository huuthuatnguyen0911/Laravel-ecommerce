<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'category_description', 'category_name', 'category_avatar', 'total_products'];
    public function childrenProducts()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
