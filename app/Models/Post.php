<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'p_id_user',
        'p_category',
        'p_title',
        'p_link_image',
        'p_content',
        'p_status',
    ];
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'p_id_user')->select(array('id', 'name','avatar'));
    }
    public function getComment()
    {
        return $this->hasMany(CommentPost::class, 'comments_p_Post_id','id');
    }
    public function getLike()
    {
        return $this->hasMany(LikePost::class, 'like_id_post', 'id');
    }
}