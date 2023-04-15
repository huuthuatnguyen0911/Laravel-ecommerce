<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comments_user_id',
        'comments_product_id',
        'comments_text',
        'comments_parent',
        'comments_status',
        'comments_rating_id',
    ];

    public function getUser(){
        return $this->hasOne(User::class,'id','comments_user_id');
    }

    public function getProduct(){
        return $this->hasOne(Product::class, 'product_id', 'comments_product_id')->select(array('product_id', 'product_name'));
    }

    public function getRating(){
        return $this->hasOne(Rating::class, 'id', 'comments_rating_id');
    }

}
