<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'appointment_date',
        'appointment_start_time',
        'appointment_end_time',
        'paid',
        'price',
        'amount_paid',
        'acuity_appointment_id',
        'acuity_appointment_type',
        'acuity_calendar_id',
        'duration',
        'acuity_action'
    ];

    public function customer(){
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
}


