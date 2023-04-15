<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'od_transaction_id',
        'od_product_id',
        'od_quantity',
        'od_price',
        'od_status'
    ];

    public function getMainImage()
    {
        return $this->hasOne(MultiplePicture::class, 'product_id', 'od_product_id')->oldest()->select(array('product_id', 'link_image'));
    }
    public function getProduct(){
        return $this->hasOne(Product::class, 'product_id', 'od_product_id')->select(array('product_id', 'product_name'));
    }
    public function getTransaction(){
        return $this->hasOne(Transaction::class, 'id', 'od_transaction_id')->select(array('id','transactions_user_id','transactions_name','transactions_phone','transactions_address'));
    }
}
