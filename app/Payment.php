<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = "payments";
    protected $primaryKey = "id";

    protected $fillable = [
        'customer_id',
        'amount',
        'created_at',
        'payment_type',
        'raw_response',
        'payment_status',
        'transaction_id',
        'updated_at',
        'comments',
        'updated_by',
        'stripe_charge_id',
        'stripe_invoice',
        'stripe_card_last_4',
        'stripe_card_exp_month',
        'stripe_card_exp_year',
        'stripe_receipt_url',
        'stripe_currency',
    ];

    public function customer(){
        return $this->hasOne('App\User','id','customer_id');
    }

}
