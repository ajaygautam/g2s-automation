<?php

namespace App\Console\Commands;

use App\Customer;
use App\Payment;
use Illuminate\Console\Command;
use Stripe\Charge;
use Stripe\Stripe;

class StripeCharge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripecharge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stripe charge cron';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        // die;
         $customers = Customer::with('membership','last_visit','peak_hours_usage','off_peak_hours_usage')->where('next_billing_date',date('Y-m-d'))->get();

         $peak_hour_charge = 60; 
         $off_peak_hour_charge = 45;
         $discount_play = 15;  //in percent

        foreach($customers as $customer){
            // echo count($customer->peak_hours_usage);
            // pa($customer);die;
            $used_peak_hours = $used_off_peak_hours = 0;
            
            if(count($customer->peak_hours_usage)){
                $used_peak_hours = $customer->peak_hours_usage[0]->peak_hours_used; 
            }
            if(count($customer->off_peak_hours_usage)){
                $used_off_peak_hours = $customer->off_peak_hours_usage[0]->off_peak_hours_used; 
            }
            
            $included_peak_hours = $customer->membership->included_peak_hours;
            $included_off_peak_hours = $customer->membership->included_off_peak_hours;
   
            $additional = (($used_peak_hours - $included_peak_hours) * $peak_hour_charge) +  (($used_off_peak_hours - $included_off_peak_hours) * $off_peak_hour_charge);
            $additional_final = $additional - ($additional * $discount_play)/100;

            if($additional_final>0){
                $chargable_amount = $customer->membership->cost + $additional_final;
            }
            else{
                $chargable_amount = $customer->membership->cost;
            }
            // pa($chargable_amount);

            if($chargable_amount > 0){
                $charge = Charge::create([
                    "amount" => $chargable_amount * 100, //convert into cents
                    "currency" => "usd",
                    "customer" => $customer->stripe_customer_id,
                    "description" => "Play charges"
                  ]);

                if($charge){
                    $payment = Payment::create([
                        'customer_id' => $customer->id,
                        'amount' => $chargable_amount,
                        'payment_type' => $additional_final>0 ? 'membership_fee_plus_additional' : 'membership_fee' ,
                        'payment_status' => $charge->status,
                        'stripe_charge_id' => $charge->id,
                        'stripe_card_last_4' => $charge->source->last4,
                        'stripe_card_exp_month' => $charge->source->exp_month,
                        'stripe_card_exp_year' => $charge->source->exp_year,
                        'stripe_receipt_url' => $charge->receipt_url,
                        'stripe_currency' => $charge->currency,
                        'raw_response' => json_encode($charge),
                    ]);
                
                    //update next billing date
                    $next_billing_date = date('Y-m-d', strtotime('+1 month'));
                    if($next_billing_date != $customer->plan_ends_on)
                    {
                        $customer->next_billing_date = $next_billing_date;
                        $customer->save();
                    }
                }    
            }


        } 
    }
}
