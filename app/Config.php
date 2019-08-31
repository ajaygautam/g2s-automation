<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = "config";
    protected $primaryKey = "id";
    protected $timestamp = false;

    protected $fillable = [
        'config_key',
        'config_value',
        'location_code',
    ];

}
