<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = "payments";
    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'amount',
        'created_at',
        'payment_for',
        'raw_response',
        'payment_status',
        'transaction_id',
        'updated_at',
        'comments',
        'updated_by',
        'stripe_customer_id',
        'stripe_charge_id',
        'stripe_balance_transaction',
        'stripe_invoice',
        'stripe_card_last_4',
        'stripe_card_exp_month',
        'stripe_card_exp_year',
        'stripe_payment_fingureprint',
        'stripe_receipt_url',
        'stripe_payment_created',
        'stripe_currency',
    ];
}
