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
        'set_password_hash',
        'home_location_code'
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

    public function customerPlan(){
        return $this->hasOne('App\CustomerPlan','customer_id','id');
    }


    public function peak_hours_usage(){
        return $this->hasMany('App\Appointment', 'customer_id', 'id')
            ->where(function($query){
             $query->whereIn(DB::raw('dayname(appointment_date)'),\config('settings.peak_days'));
             $query->orWhereIn('appointment_date',\config('settings.holiday_dates'));
            })
            
            ->selectRaw('SUM(duration)/60 as peak_hours_used,customer_id')
            ->groupBy(['customer_id'])
            ;
    }
    
    public function off_peak_hours_usage(){
        return $this->hasMany('App\Appointment', 'customer_id', 'id')
            ->where(function($query){
                $query->whereIn(DB::raw('dayname(appointment_date)'),\config('settings.off_peak_days'));
                $query->WhereNotIn('appointment_date',\config('settings.holiday_dates'));
            })    
            ->selectRaw('SUM(duration)/60 as off_peak_hours_used, customer_id')
            ->groupBy(['customer_id'])
            ;

    }

    // public function peak_hours_usage(){
    //     return $this->hasMany('App\Appointment', 'customer_id', 'id')
    //         // ->where('acuity_action','scheduled')
    //         // ->where(DB::raw('Month(appointment_date)'),date("n",strtotime("-1 month")))
    //         ->whereIn(DB::raw('dayname(appointment_date)'),\config('settings.peak_days'))
    //         ->orWhereIn('appointment_date',\config('settings.holiday_dates'))
    //         ->selectRaw('SUM(duration) as peak_hours_used,customer_id')
    //         ->groupBy(['customer_id'])
    //         ;
    // }
    
    // public function off_peak_hours_usage(){
    //     return $this->hasMany('App\Appointment', 'customer_id', 'id')
    //         // ->where('acuity_action','scheduled')
    //         // ->where(DB::raw('Month(appointment_date)'),date("n",strtotime("-1 month")))
    //         ->whereIn(DB::raw('dayname(appointment_date)'),\config('settings.off_peak_days'))
    //         ->orWhereNotIn('appointment_date',\config('settings.holiday_dates'))
    //         ->selectRaw('SUM(duration) as off_peak_hours_used, customer_id')
    //         ->groupBy(['customer_id'])
    //         ;

    // }


    /*
    SELECT id,customer_id, duration, appointment_date, DAYNAME(appointment_date) 
    FROM `appointments` 
    WHERE 
    (
    DAYNAME(appointment_date) IN ('Friday', 'Saturday', 'Sunday') 
    OR `appointment_date` IN ('2019-07-04', '2019-09-13', '2019-09-14', '2019-09-15', '2019-09-16', '2019-09-17', '2019-09-18', '2019-09-20') 
    )
    AND `appointments`.`customer_id` IN ('7') 
    #GROUP BY `customer_id`

    ;

    SELECT 
    id,customer_id, duration, appointment_date, DAYNAME(appointment_date) 
    FROM `appointments` 
    WHERE 
    (
    DAYNAME(appointment_date) IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday') 
    AND `appointment_date` NOT IN ('2019-07-04', '2019-09-13', '2019-09-14', '2019-09-15', '2019-09-16', '2019-09-17', '2019-09-18','2019-09-20') 
    )
    AND `appointments`.`customer_id` IN ('7') 

    ;
    */ 

    
}
