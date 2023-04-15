<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;
    protected $fillable = [
        'ts_id_staff',
        'ts_transaction_id',
        'ts_note',
        'ts_status',
    ];

    public function getStaff()
    {
        return $this->hasOne(User::class, 'id', 'ts_id_staff')->select(array('id', 'name'));
    }

    // order
    public function getOrder()
    {
        return $this->hasMany(Order::class, 'od_transaction_id', 'ts_transaction_id' );
    }
    
    public function getTransaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'ts_transaction_id');
    }
}
