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
         
        // DB::connection()->enableQueryLog();
        $customers = User::with('membership','peak_hours_usage','off_peak_hours_usage')
                        ->get();
        
        // $queries = DB::getQueryLog();
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
                        $used_peak_hours = ($customer->peak_hours_usage[0]->peak_hours_used); // covert minutes to hours
                    }
                    if(count($customer->off_peak_hours_usage)){
                        $used_off_peak_hours = ($customer->off_peak_hours_usage[0]->off_peak_hours_used); //convert minutes to hours
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
