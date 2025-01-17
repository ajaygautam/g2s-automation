<?php

namespace App\Http\Controllers;

use App\Config;
use App\Customer;
use App\CustomerPlan;
use App\FoodDrinksCharge;
use App\Mail\SetPasswordMailer;
use App\Membership;
use App\Payment;
use App\PaymentMethod;
use App\Resource;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash as IlluminateHash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use stdClass;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token as StripeToken;


class StripeController extends Controller
{

    public function StripeSubscriptionPost(Request $request){
       
       $allRequests = $request->all();

       $validatedData = $request->validate([
            'customer_name' => 'required',
            'primary_email' => 'required|email',
            'password' => 'required',
            'cpassword' => 'required|same:password',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'referral' => 'required',
            'referral_other' => 'sometimes|required',
            'tandccheck' => 'required',
           
       ],
        [
            'cpassword.required' => 'Confirm Password is required',
            'cpassword.same' => 'Password and Confirm Password must match',
            'referral_other.required' => 'Referred by Other is required',
            'tandccheck.required' => 'You need to accept Terms and Conditions to proceed further',
           
        ]
    );


        // die('this is called');


      $stripe_secret = config('settings.keys.STRIPE_SECRET');

       $stripeToken = $request->stripeToken;
       Stripe::setApiKey($stripe_secret);

       $membership = Membership::where('plan_code',$request->plan_code)->first();
       
       $customer = User::where('email', $request->primary_email)->first();

      
       $chargable_amount = self::CalculateChargeableAmount([
           'email' => $request->primary_email,
           'membership' => $membership,
           'request' => $request
       ]);
       

       if($chargable_amount > 0){
            
            try{
                $customer = self::GetStripeCustomer([
                    'stripeToken' => $stripeToken,
                    'name' => $request->customer_name,
                    'email' => $request->primary_email,
                    'membership' => $membership,
                    'request' => $request,
                ]);
         
                $payment = self::StripeCharge([
                    'customer' => $customer,
                    'amount' => $chargable_amount,
                    'request' => $request,
                ]);
                return Redirect::to('payment_success/'.$payment->id);
            }catch(Exception $e){
               return throwExpection($e);
            }
       }

       
    }

    public function paymentSuccessPage($id){
        $payment = Payment::find($id);
        $link = $payment->stripe_receipt_url;
        
        return view('payment_success',['link'=>$link]);
    }


    public static function CalculateChargeableAmount($dataObj){
        $email = $dataObj['email'];
        $membership = $dataObj['membership'];
        $request = $dataObj['request'];

       
        $customer = User::where('email', $email)->first();
        
        $peak_month_starts =   Config::where('location_code', $membership->location_code)
                    ->where('config_key', 'Peak Start Month')
                    ->first()->config_value;
        
        $off_peak_month_starts =   Config::where('location_code', $membership->location_code)
                    ->where('config_key', 'Off Peak Start Month')
                    ->first()->config_value;

        

        $isPeakMonth = isPeakMonth($peak_month_starts, $off_peak_month_starts);
       
        $tax = Config::where('location_code', $membership->location_code)
                    ->where('config_key', 'Tax')
                    ->first()->config_value;
 
 
        
        if($membership->tax_exemption==1){
             $tax = 0;
         }
 
         if($isPeakMonth==1)
         {
             if($request->yearly_commitment == 1){
                 $cost = $membership->monthly_due_on_season_yc; 
             }   
             else{
                 $cost = $membership->monthly_due_on_season_mc; 
             }
         } else{
             if($request->yearly_commitment == 1){
                 $cost = $membership->monthly_due_off_season_yc; 
             }   
             else{
                 $cost = $membership->monthly_due_off_season_mc; 
             }
         }
 
         $membership_cost = $cost + ($cost*$tax)/100;
         $membership_cost = round($membership_cost,2);
 
         return $membership_cost;

    }

    public static function CalculateChargeableOverageAmount($customer){

        $additional_final = 0;
        $membership = $customer->membership[0];
        
        // pa($customer->customerPlan);

        $discount_food = $membership->food_discount;  //in percent
        $discount_play = $membership->play_discount;  //in percent
                
        $used_peak_hours = $used_off_peak_hours = 0;
        
        if(count($customer->peak_hours_usage)){
            $used_peak_hours = ($customer->peak_hours_usage[0]->peak_hours_used)/60; // covert minutes to hours
        }
        if(count($customer->off_peak_hours_usage)){
            $used_off_peak_hours = ($customer->off_peak_hours_usage[0]->off_peak_hours_used)/60; //convert minutes to hours
        }

        $included_peak_hours = $customer->membership[0]->included_peak_hours;
        $included_off_peak_hours = $customer->membership[0]->included_off_peak_hours;

        $resource = Resource::find('1');    
        $peak_hour_charge = $resource->peak_price; 
        $off_peak_hour_charge = $resource->off_peak_price; 

        $additional = (($used_peak_hours - $included_peak_hours) * $peak_hour_charge) +  (($used_off_peak_hours - $included_off_peak_hours) * $off_peak_hour_charge);

        $additional_final = $additional - ($additional * $discount_play)/100;


        //Food and Drinks
        $food_charges = isset($customer->food_drink_charges_monthly_total->total_monthly)?$customer->food_drink_charges_monthly_total->total_monthly:0;
        $food_charges_discounted =  $food_charges - ($food_charges*$discount_food)/100;

        //Monthly 
        $peak_month_starts =   Config::where('location_code', $membership->location_code)
                    ->where('config_key', 'Peak Start Month')
                    ->first()->config_value;
        
        $off_peak_month_starts =   Config::where('location_code', $membership->location_code)
                    ->where('config_key', 'Off Peak Start Month')
                    ->first()->config_value;

        

        $isPeakMonth = isPeakMonth($peak_month_starts, $off_peak_month_starts);
       
        $tax = Config::where('location_code', $membership->location_code)
                    ->where('config_key', 'Tax')
                    ->first()->config_value;
 
 
        
        if($membership->tax_exemption==1){
             $tax = 0;
         }
 
         if($isPeakMonth==1)
         {
             if($customer->customerPlan->yearly_commitment == 1){
                 $cost = $membership->monthly_due_on_season_yc; 
             }   
             else{
                 $cost = $membership->monthly_due_on_season_mc; 
             }
         } else{
             if($customer->customerPlan->yearly_commitment == 1){
                 $cost = $membership->monthly_due_off_season_yc; 
             }   
             else{
                 $cost = $membership->monthly_due_off_season_mc; 
             }
         }


 
         $cost = $cost + $food_charges_discounted + $additional_final;

         $membership_cost = $cost + ($cost*$tax)/100;
         $membership_cost = round($membership_cost,2);
 
         return $membership_cost;

    }


    public static function StripeCharge($dataObj){
      
        $stripe_secret = config('settings.keys.STRIPE_SECRET');
        Stripe::setApiKey($stripe_secret);

        $customer = $dataObj['customer'];
        $amount = $dataObj['amount'];
        
        $comments = isset($dataObj['comments'])?$dataObj['comments']:'New membership';
        
        
        $charge = \Stripe\Charge::create([
            "amount" => $amount * 100, // convert to cents - stripe accepts in cents
            "currency" => "usd",
            "customer" => $customer->stripe_customer_id, // Stripe customer ID
            "description" => $comments
        ]);
        
        if($charge){
            $payment = Payment::create([
                'customer_id' => $customer->id,
                'amount' => $amount,
                'payment_status' => $charge->status,
                'stripe_charge_id' => $charge->id,
                'stripe_receipt_url' => $charge->receipt_url,
                'stripe_currency' => $charge->currency,
                'stripe_invoice_number' => $charge->invoice,
                'comments' => $comments,
            ]);

            $paymentMethod = PaymentMethod::firstOrCreate([
                'customer_id' => $customer->id,
                'card_last_four' => $charge->source->last4,
                'exp_month' => $charge->source->exp_month,
                'exp_year' => $charge->source->exp_year,
            ]);
        
            return $payment;
        }


    }

    public static function StripeCustomerCreate($dataObj){
     
            $stripeCustomer = \Stripe\Customer::create($dataObj);
            return $stripeCustomer;
    }

    public static function GetStripeCustomer($dataObj){
        $stripe_token = $dataObj['stripeToken'];
        $name = $dataObj['name'];
        $email = $dataObj['email'];
        $membership = $dataObj['membership'];
        $request = $dataObj['request'];


        $customer = User::where('email', $email)->first();

        if($customer=='')
        {
           
            $stripeCustomer = self::StripeCustomerCreate([
                'source' => $stripe_token,
                'name' => $name,
                'email' => $email,
            ]);
          
            if($stripeCustomer){
                $name = explode(' ', $name);
                if(isset($request->plan_starts_on)&&($request->plan_starts_on!='')){
                    $plan_starts_on = $request->plan_starts_on;
                    $plan_starts_on_ts = strtotime($plan_starts_on);
                    $plan_ends_on_ts = strtotime('+1 year', $plan_starts_on_ts);
                    $plan_ends_on =  date('Y-m-d', $plan_ends_on_ts);
                }
                else{
                    $plan_starts_on = date('Y-m-d');
                    $plan_ends_on = date('Y-m-d', strtotime('+1 year'));
                }
                
                $customer = User::create([
                        'email' => $email,
                        'password' => bcrypt($request->password),
                        'first_name' => $name[0],
                        'last_name' => $name[count($name)-1],
                        'stripe_customer_id' => $stripeCustomer->id,
                        'address'=>$request->address,
                        'city'=>$request->city,
                        'state'=>$request->state,
                        'county'=>$request->county,
                        'country'=>$request->country,
                        'zipcode'=>$request->zipcode,
                        'set_password_hash'=>md5(str_random(8)),
                        'customer_type'=>4,
                        'home_location_code'=>$membership->location_code,
                    ]
                );

                $customerPlan = CustomerPlan::create([
                    'customer_id' => $customer->id, 
                    'membership_plan_id' => $membership->id,
                    'plan_starts_on' => $plan_starts_on ,
                    'plan_ends_on' => $plan_ends_on,
                    'referral' => $request->referral,
                    'referral_other' => $request->referral_other,
                    'location_code' => $membership->location_code,
                    'yearly_commitment' => $request->yearly_commitment,
                ]);

                // Mail::to($customer->email)
                //     ->send(new SetPasswordMailer($customer));
                
            }
        }

        return $customer;
    }

    
    //same as command StripeCharge - will be removed from here
    public function charge(){
       
        // DB::connection()->enableQueryLog();
        $customers = User::with('membership','customerPlan','food_drink_charges_monthly_total','peak_hours_usage','off_peak_hours_usage')
                          ->where('customer_type','4')  
                          ->orderBy('id','desc')
                        ->get();


   
        foreach($customers as $customer){
           //process only members

           


           $chargable_amount = self::CalculateChargeableOverageAmount($customer);
            // echo "<br />";

        //    die;
           if($chargable_amount > 0){
            $request = new stdClass();
            $request->stripe_charge_comment = "Monthly charge";
                try{
                    $payment = self::StripeCharge([
                        'customer' => $customer,
                        'amount' => $chargable_amount,
                        'comments' => "Membership cost",
                    ]);
                    
                }catch(Exception $e){
                    // echo "dasdas";
                    // return throwExpection($e);
                }
            }

            
           
        } 
    }
}
