<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 
        'password',
        'customer_type',
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'country',
        'county',
        'zipcode',
        'phone_1',
        'phone_2',
        'phone_3',
        'email_2',
        'email_3',
        'notes',
        'stripe_customer_id',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function membership(){
        return $this->hasManyThrough(
            'App\Membership',
            'App\CustomerPlan',
            'customer_id', // Foreign key for categories in KnowledgeAreaCategory...
            'id', // Primary key on KnowledgeArea table...
            'id', // Primary key on Category table...
            'membership_plan_id' // Foreign key for KnowledgeAreas in KnowledgeAreaCategory...
        );
    }


    public function peak_hours_usage(){
        return $this->hasMany('App\Appointment', 'customer_id', 'id')
            ->where('acuity_action','scheduled')
            // ->where(DB::raw('Month(appointment_date)'),date("n",strtotime("-1 month")))
            ->whereIn(DB::raw('dayname(appointment_date)'),\config('settings.peak_days'))
            ->selectRaw('SUM(duration) as peak_hours_used,customer_id')
            ->groupBy(['customer_id'])
            ;
    }
    
    public function off_peak_hours_usage(){
        return $this->hasMany('App\Appointment', 'customer_id', 'id')
            ->where('acuity_action','scheduled')
            // ->where(DB::raw('Month(appointment_date)'),date("n",strtotime("-1 month")))
            ->whereIn(DB::raw('dayname(appointment_date)'),\config('settings.off_peak_days'))
            ->selectRaw('SUM(duration) as off_peak_hours_used, customer_id')
            ->groupBy(['customer_id'])
            ;

    }

    
}
