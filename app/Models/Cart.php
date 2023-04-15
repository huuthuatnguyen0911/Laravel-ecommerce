<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_product',
        'quantity',
        'check',
    ];
    public function getProduct()
    {
        return $this->hasOne(Product::class, 'product_id', 'id_product')->select(array('product_id', 'product_name'));
    }
    public function user()
    {
        return $this->hasOne(user::class, 'id', 'id_user');
    }
}
