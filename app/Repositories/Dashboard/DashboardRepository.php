<?php

namespace App\Repositories\Dashboard;

use App\Models\Dashboard;
use App\Repositories\BaseRepository;
use App\Repositories\Dashboard\DashboardRepositoryInterface;

class DashboardRepository extends BaseRepository implements DashboardRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return  Dashboard::class;
    }

}