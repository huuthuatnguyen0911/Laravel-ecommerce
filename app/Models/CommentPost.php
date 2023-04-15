<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'comments_p_user_id',
        'comments_p_Post_id',
        'comments_p_text',
        'comments_p_parent',
        'comments_p_status',
    ];

    // lấy user
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'comments_p_user_id')->select(array('id', 'name','avatar'));
    }
}
