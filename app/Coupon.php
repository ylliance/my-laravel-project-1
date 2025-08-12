<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $table = 'coupons';
    protected $fillable = [
        'coupon_no',
        'shop',
        'type',
        'value',
        'status',
        'member_id',
        'used_at',
    ];

    public function member()
    {

        return $this->hasOne('App\Member', 'id', 'member_id');
    }
}
