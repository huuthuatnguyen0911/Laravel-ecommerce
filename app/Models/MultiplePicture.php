<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiplePicture extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'product_id',
        'link_image',
        'alt_image',
    ];
    public function getProduct()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }

    public function getItem()
    {
        return $this->hasOne(PersonalItem::class, 'item_id', 'product_id');
    }
}
