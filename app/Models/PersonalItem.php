<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'item_name',
        'item_description',
        'item_sub_description',
        'category_id',
    ];
    public function category()
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }
    public function categoryName()
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id')->select(array('category_id', 'category_name'));
    }
    public function getMainImage()
    {
        return $this->hasOne(MultiplePicture::class, 'product_id', 'item_id')->oldest();
    }
    public function getAllImage()
    {
        return $this->hasMany(MultiplePicture::class, 'product_id', 'item_id');
    }
    public function getArchive()
    {
        return $this->hasOne(Archive::class, 'product_id', 'item_id');
    }
}
