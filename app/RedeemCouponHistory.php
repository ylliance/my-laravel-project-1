<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemCouponHistory extends Model
{
    //
    protected $table = 'redeem_coupon_histories';
    protected $fillable = [
        'member_id',
        'user_id',
        'coupon_no',
        'comment',
    ];
}
