<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerPlan;
use App\Mail\SetPasswordMailer;
use App\Membership;
use App\Payment;
use App\PaymentMethod;
use App\Resource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash as IlluminateHash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

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

       $stripeToken = $request->stripeToken;
       Stripe::setApiKey(env('STRIPE_SECRET'));

       $membership = Membership::where('plan_code',$request->plan_code)->first();
       
       $customer = User::where('email', $request->primary_email)->get();

       $isPeakMonth = 0;
       $peak_months = ['01','02','03','04','09','10','11','12'];
       $off_peak_months = ['05','06','07','08'];
       $current_month = date('m');
   
       if(in_array($current_month,$peak_months)){
           $isPeakMonth = 1;
       }
      // $cost = $isPeakMonth==1?$membership->monthly_due_on_season:$membership->monthly_due_off_season;
       $tax = config('settings.tax');
       
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



       if($customer->count()== 0){
            $stripeCustomer = \Stripe\Customer::create([
                'source' => $stripeToken,
                'name' => $request->customer_name,
                'email' => $request->primary_email,
            ]);
            if($stripeCustomer){
                $name = explode(' ', $request->customer_name);
                $plan_starts_on = date('Y-m-d');
                $plan_ends_on = date('Y-m-d', strtotime('+1 year'));
                // $next_billing_date = date('Y-m-d', strtotime('+1 month'));

                $customer = User::create([
                        'email' => $request->primary_email,
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

        $charge = \Stripe\Charge::create([
            "amount" => $membership_cost * 100, // convert to cents - stripe accepts in cents
            "currency" => "usd",
            "customer" => $customer->stripe_customer_id, // Stripe customer ID
            "description" => "Charge for ". $request->customer_name
        ]);

        if($charge){
            $payment = Payment::create([
                'customer_id' => $customer->id,
                'amount' => $membership_cost,
                'payment_status' => $charge->status,
                'stripe_charge_id' => $charge->id,
                'stripe_receipt_url' => $charge->receipt_url,
                'stripe_currency' => $charge->currency,
                'stripe_invoice_number' => $charge->invoice
            ]);

            $paymentMethod = PaymentMethod::create([
                'customer_id' => $customer->id,
                // 'card_brand' => ,
                'card_last_four' => $charge->source->last4,
                'exp_month' => $charge->source->exp_month,
                'exp_year' => $charge->source->exp_year,
            ]);
        }    

        return Redirect::to('payment_success/'.$payment->id);
    }

    public function paymentSuccessPage($id){
        $payment = Payment::find($id);
        $link = $payment->stripe_receipt_url;
        
        return view('payment_success',['link'=>$link]);
    }


    //same as commange StripeCharge - will be removed from here
    public function charge(){
        
        Stripe::setApiKey(env('STRIPE_SECRET'));
         
        // DB::connection()->enableQueryLog();
        $customers = User::with('membership','peak_hours_usage','off_peak_hours_usage')
                        ->get();
        
        $queries = DB::getQueryLog();
        // allQuery($queries);
        
        // die;

       
        // get Resource price
        //For now, resource_id =1 is used

        $resource = Resource::find('1');    
        $peak_hour_charge = $resource->peak_price; 
        $off_peak_hour_charge = $resource->off_peak_price;



        foreach($customers as $customer){
           //process only members
          
            if(count($customer->membership)>0)
            {
                if($customer->membership[0]->frequency == 0){
                   //fetch discount 
                    $discount_play = $customer->membership[0]->play_discount;  //in percent
                
                    $used_peak_hours = $used_off_peak_hours = 0;
                
                    if(count($customer->peak_hours_usage)){
                        $used_peak_hours = ($customer->peak_hours_usage[0]->peak_hours_used)/60; // covert minutes to hours
                    }
                    if(count($customer->off_peak_hours_usage)){
                        $used_off_peak_hours = ($customer->off_peak_hours_usage[0]->off_peak_hours_used)/60; //convert minutes to hours
                    }
                
                    $included_peak_hours = $customer->membership[0]->included_peak_hours;
                    $included_off_peak_hours = $customer->membership[0]->included_off_peak_hours;
    
                    $additional = (($used_peak_hours - $included_peak_hours) * $peak_hour_charge) +  (($used_off_peak_hours - $included_off_peak_hours) * $off_peak_hour_charge);
                    $additional_final = $additional - ($additional * $discount_play)/100;
        
                    if($additional_final>0){
                        $chargable_amount = $customer->membership[0]->cost + $additional_final;
                    }
                    else{
                        $chargable_amount = $customer->membership[0]->cost;
                    }

                    Log::info($customer->id.' -> '.$chargable_amount);

                    if($chargable_amount > 0){
                        $charge = Charge::create([
                            "amount" => $chargable_amount * 100, //convert into cents
                            "currency" => "usd",
                            "customer" => $customer->stripe_customer_id,
                            "description" => "Monthly membership charges"
                        ]);
        
                        if($charge){
                            $payment = Payment::create([
                                'customer_id' => $customer->id,
                                'amount' => $chargable_amount,
                                'payment_status' => $charge->status,
                                'stripe_charge_id' => $charge->id,
                                'stripe_receipt_url' => $charge->receipt_url,
                                'stripe_currency' => $charge->currency,
                                'stripe_invoice_number' => $charge->invoice
                            ]);
                        }    
                    }      
                } //frequency==0

               
            }
           
        } 
    }
}
