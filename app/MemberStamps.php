<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberStamps extends Model
{
    protected $table = 'member_stamps';
    protected $fillable = [
        'member_id',
        'shop',
        'address',
        'email',
        'phone_number',
        'qr_code',
        'is_used'
    ];
}
