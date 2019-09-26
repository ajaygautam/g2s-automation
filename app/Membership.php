<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
   protected $table = "membership_plans" ;
   protected $primaryKey = "id" ;

   protected $fillable = [
      'stripe_product_id',
      'plan_name',
      'frequency',
      'location_code',
      'included_peak_hours',
      'included_off_peak_hours',
      'included_lessons',
      'play_discount',
      'food_discount',
      'drinks_discount',
      'events_discount',
      'monthly_due_on_season_yc',
      'monthly_due_off_season_yc',
      'monthly_due_on_season_mc',
      'monthly_due_off_season_mc',
      'plan_type',
      'plan_code',
      'tax_exemption',
   ];

   public function customers(){
      return $this->hasMany('App\Customer','membership_plan_id', 'membership_plan_id');
   }

}
