<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPlan extends Model
{
    protected $table = 'customer_plans';
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'membership_plan_id',
        'plan_starts_on',
        'plan_ends_on',
        'is_plann_hold',
        'plan_hold_starts_on',
        'plan_hold_ends_on',
        'location_code',
    ];
}
