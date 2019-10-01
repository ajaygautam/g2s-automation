<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "locations";
    public $timestamps = false;
    protected $fillable = [
        'location_name',
        'location_code'
    ];
}
