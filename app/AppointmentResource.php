<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentResource extends Model
{
    protected $table = "appointment_resources";
    public $timestamps = false;
    protected $fillable = [
        'appointment_id',
        'resource_id'
    ];

}
