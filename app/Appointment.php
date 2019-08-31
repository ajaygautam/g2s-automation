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
        'acuity_appointment_id',
        'peak_hours_used',
        'off_peak_hours_used',
        'acuity_action'
    ];

    public function customer(){
        return $this->hasOne('App\Customer', 'id', 'customer_id');
    }
}


