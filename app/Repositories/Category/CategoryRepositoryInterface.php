<?php

namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    //Lấy tất cả sản phẩm
    public function getAllCategory();
    public function updateWhere($id,$attributes = []);
    public function deleteWhere($id);
    public function findWhere($id);
    public function deleteWithAllProducts($id);
    public function searchPaginationCondition($keySearchCategory, $number);
}