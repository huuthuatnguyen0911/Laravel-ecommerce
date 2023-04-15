<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_archive',
        'product_id',
        'quantity',
        'import_price',
        'price',
        'deploy'
    ];
    public function getProduct(){
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
}
