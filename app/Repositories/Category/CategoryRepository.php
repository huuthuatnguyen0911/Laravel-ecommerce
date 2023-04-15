<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;
use  App\Repositories\Category\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return  Category::class;
    }

    public function getAllCategory()
    {
    }
    public function updateWhere($id, $attributes = [])
    {
        $result = $this->model->where("category_id", $id);
        if ($result) {
            $update = $result->update($attributes);
            return $update;
        }
        return false;
    }

    public function deleteWhere($id)
    {
        $result = $this->model->where("category_id", $id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function findWhere($id)
    {
        $result = $this->model->where("category_id", $id)->exists();
        if ($result == '') {
            return true;
        }
        return false;
    }

    public function deleteWithAllProducts($id)
    {
        $category = $this->model->where("category_id", $id)->first();
        $category->childrenProducts()->delete();
        $result = $this->model->where("category_id", $id)->delete();
        if ($result == '1') {
            return true;
        }
        return false;
    }

    public function searchPaginationCondition($keySearchCategory , $number){
        return $this->model->orderBy('created_at', 'DESC')->where('category_name','like', '%'.$keySearchCategory.'%')->paginate($number);
    }
}
