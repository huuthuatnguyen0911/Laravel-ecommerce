<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'provider',
        'provider_id',
        'avatar',
        'avatar_origin',
        'active_status',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * get inf role
     */
    public function getInfRole()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    // check friend
    public function getFridends()
    {
        return $this->hasMany(FriendShip::class, 'fs_id_user', 'id');
    }

    // Đơn hàng
    public function getTransport()
    {
        return $this->hasMany(Transport::class, 'ts_id_staff', 'id');
    }

    // lấy infor
    public function getInfor()
    {
        return $this->hasOne(InforUser::class, 'id_user', 'id');
    }

    // bài viết
    public function getPosts()
    {
        return $this->hasMany(Post::class, 'p_id_user', 'id');
    }
}
