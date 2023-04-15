<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendShip extends Model
{
    use HasFactory;
    protected $fillable = [
        'fs_id_user',
        'fs_id_friend',
        'fs_status',
    ];

    public function getUser(){
        return $this->hasOne(User::class,'id','fs_id_friend');
    }
}
