<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Customer extends Model
{

    use Billable;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_type',
        'home_location_code',
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'country',
        'primary_phone',
        'additional_phone_numbers',
        'primary_email',
        'additional_emails',
        'notes',
        'is_member',
        'membership_plan_id',
        'plan_starts_on',
        'plan_ends_on',
        'is_plan_hold',
        'plan_hold_starts_on',
        'plan_hold_ends_on',
        'stripe_product_id',
        'stripe_customer_id',
        'stripe_subscription_id',
        'next_billing_date',
        'status'
    ];

    public function membership(){
        return $this->hasOne('App\Membership', 'id', 'membership_plan_id');
    } 
    
    public function last_visit(){
        return $this->hasOne('App\Appointment', 'customer_id', 'id')->orderBy('id', 'desc');
    }
    
    public function peak_hours_usage(){
        // return $this->hasOne('App\Appointment', 'customer_id', 'id')->selectRaw('SUM(peak_hours_used) as peak_hours_used');
        return $this->hasMany('App\Appointment', 'customer_id', 'id')->where('acuity_action','scheduled')->selectRaw('SUM(peak_hours_used) as peak_hours_used, customer_id')->groupBy('customer_id');


    //   return $this->hasMany('App\Appointment')
    //             ->selectRaw('SUM(peak_hours_used) as peak_hours_used')
    //             ->groupBy('customer_id');
    }
    
    public function off_peak_hours_usage(){
        // return $this->hasOne('App\Appointment', 'customer_id', 'id')->selectRaw('SUM(off_peak_hours_used) as off_peak_hours_used');
        return $this->hasMany('App\Appointment', 'customer_id', 'id')->where('acuity_action','scheduled')->selectRaw('SUM(off_peak_hours_used) as off_peak_hours_used, customer_id')->groupBy('customer_id');

    }

    
    
}
