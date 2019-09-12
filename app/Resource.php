<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resources';
    protected $primaryKey = 'id';
    protected $fillable = [
        'location_code',
        'resource_type',
        'resource_name',
        'off_peak_price',
        'peak_price'
    ];
}
