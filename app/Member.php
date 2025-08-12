<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $table = 'members';
    protected $fillable = [
        'username', 'email', 'phone_number', 'last_login'
    ];
}
