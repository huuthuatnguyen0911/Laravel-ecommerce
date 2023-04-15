<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'id',
        'transactions_user_id',
        'transactions_name',
        'transactions_phone',
        'transactions_address',
        'transactions_email',
        'transactions_note',
        'transactions_price',
        'transactions_method',
        'transactions_status'
    ];

    // order
    public function getOrder()
    {
        return $this->hasMany(Order::class, 'od_transaction_id', 'id' );
    }

    // lấy user
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'transactions_user_id')->select(array('id', 'name','email'));
    }

    // order khác đã giao
    public function getOrder_not_delivered()
    {
        return $this->getOrder()->where('od_status','!=', 2);
    }


}
