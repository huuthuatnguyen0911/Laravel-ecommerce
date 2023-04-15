<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InforUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_province',
        'id_district',
        'id_ward',
        'street',
        'phone',
        'date_birth',
        'content',
    ];

    // lấy tỉnh
    public function getProvince()
    {
        return $this->hasOne(Province::class, 'id', 'id_province');
    }

    // lấy quận huyện
    public function getDistrict()
    {
        return $this->hasOne(District::class, 'id', 'id_district');
    }

    // lấy Xã phường
    public function getWard()
    {
        return $this->hasOne(Ward::class, 'id', 'id_ward');
    }

}
