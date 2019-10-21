<?php

namespace App\Console\Commands;

use App\Customer;
use App\Payment;
use App\Resource;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // DB::connection()->enableQueryLog();
        $customers = User::with('membership','customerPlan','food_drink_charges_monthly_total','peak_hours_usage','off_peak_hours_usage')
        ->where('customer_type','4')  
        ->orderBy('id','desc')
        ->get();

        // TODO: fetch customers whose day(plan_starts_on) is today 


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
}
