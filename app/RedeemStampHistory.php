<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemStampHistory extends Model
{
    //
    protected $table = 'redeem_stamp_histories';
    protected $fillable = [
        'member_id',
        'user_id',
        'comment',
    ];
}
