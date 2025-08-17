<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'payment_request_id',
        'external_payment_id',
        'order_id',
        'amount_minor',
        'currency',
        'status',
        'request_payload',
        'response_payload',
        'last_notification',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
        'last_notification' => 'array',
    ];

    public function getAmountDecimalAttribute(): string
    {
        return number_format($this->amount_minor / 100, 2, '.', '');
    }
}
