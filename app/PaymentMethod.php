<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_id',
        'card_brand',
        'card_last_four',
        'exp_month',
        'exp_year',
    ];
}
