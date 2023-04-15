<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_name',
        'product_description',
        'product_sub_description',
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
        return $this->hasOne(MultiplePicture::class, 'product_id', 'product_id')->oldest();
    }
    public function getAllImage()
    {
        return $this->hasMany(MultiplePicture::class, 'product_id', 'product_id');
    }
    public function getArchive()
    {
        return $this->hasOne(Archive::class, 'product_id', 'product_id');
    }

    public function getArchivePrice()
    {
        return $this->hasOne(Archive::class, 'product_id', 'product_id')->select(array('id_archive', 'price'));
    }

    public function getRating()
    {
        return $this->hasMany(Rating::class, 'rt_product_id', 'product_id');
    }

    public function avgRating()
    {
        return $this->getRating()
            ->selectRaw('avg(rt_star) as aggregate, rt_product_id')
            ->groupBy('rt_product_id');
    }
}
