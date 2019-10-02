<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerPlan;
use App\Membership;
use App\Payment;
use App\PaymentMethod;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token as StripeToken;

class CustomersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        // $this->authorize('all', User::class);
       
         $view_elements = [];
         
         $view_elements['page_title'] = 'Customers'; 
         $view_elements['component'] = 'customers'; 
         $view_elements['menu'] = 'customers'; 
         $view_elements['breadcrumbs']['All Customers'] = array("link"=>'/customers',"active"=>'1');
         
 
         $view = viewName('customers.all');
         return view($view, $view_elements);
     }


         /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view_elements = [];

        $membership_plans = Membership::all();
         
         $view_elements['page_title'] = 'Add Customer'; 
         $view_elements['plans'] = $membership_plans; 
         $view_elements['component'] = 'customers'; 
         $view_elements['menu'] = 'customers'; 
         $view_elements['breadcrumbs']['All Customers'] = array("link"=>'/customers',"active"=>'0');
         $view_elements['breadcrumbs']['Add New Customer'] = array("link"=>'/customers',"active"=>'1');
         
 
         $view = viewName('customers.add');
         return view($view, $view_elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $allRequests = $request->all();

        $validatedData = $request->validate([
             'customer_name' => 'required',
             'primary_email' => 'required|email',
             'password' => 'required',
             'address' => 'required',
             'city' => 'required',
             'state' => 'required',
             'country' => 'required',
             'referral' => 'required',
             'referral_other' => 'sometimes|required',
             'membership_plan_id' => 'required',
             
            
        ],
         [
             'cpassword.required' => 'Confirm Password is required',
             'cpassword.same' => 'Password and Confirm Password must match',
             'referral_other.required' => 'Referred by Other is required',
             'membership_plan_id.required' => 'Membership Plan is required',
         ]
     );
 
 
         // die('this is called');
 
 
       $stripe_secret = config('settings.keys.STRIPE_SECRET');
 
        $stripeToken = $request->stripeToken;

        Stripe::setApiKey($stripe_secret);
 
        $membership = Membership::find($request->membership_plan_id);
        
        $customer = User::where('email', $request->primary_email)->first();
    //  echo  $customer;
    //     // if($customer)
    //     // pa($customer);
    //     die();

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
         $membership_cost = round($membership_cost,2);


         Log::info('membership cost=>'.$membership_cost);
        //  die;
 
        if($customer==''){
             $stripeCustomer = \Stripe\Customer::create([
                 'source' => $stripeToken,
                 'name' => $request->customer_name,
                 'email' => $request->primary_email,
             ]);

             if($stripeCustomer){
                 $name = explode(' ', $request->customer_name);

                 $plan_starts_on = $request->plan_starts_on;

                 $plan_starts_on_ts = strtotime($plan_starts_on);
                 $plan_ends_on_ts = strtotime('+1 year', $plan_starts_on_ts);
                 $plan_ends_on =  date('Y-m-d', $plan_ends_on_ts);

                
                 
 
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
                         'customer_type'=>'4',
                         'set_password_hash'=>md5(str_random(8)),
                         'home_location_code'=>Auth::user()->home_location_code,
                     ]
                 );
 
                 $customerPlan = CustomerPlan::create([
                     'customer_id' => $customer->id, 
                     'membership_plan_id' => $membership->id,
                     'plan_starts_on' => $plan_starts_on ,
                     'plan_ends_on' => $plan_ends_on,
                     'referral' => $request->referral,
                     'referral_other' => $request->referral_other,
                    //  'location_code' => $membership->location_code,
                     'location_code' => Auth::user()->home_location_code,
                     'yearly_commitment' => $request->yearly_commitment,
                 ]);
 
                 // Mail::to($customer->email)
                 //     ->send(new SetPasswordMailer($customer));
                 
             }
        }
 
        Log::info('Stripe Customer ID=>'.$customer->stripe_customer_id);


        if($request->charge_customer=='1'){


            // die;
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
            
        }

        $request->session()->flash('success_message', 'New customer is created successfully');
        return redirect("/dashboard/customers");


    }





       public function datatablesAllCustomers()
     {
        // DB::connection()->enableQueryLog();
        $customers = User::with('customerPlan','membership','peak_hours_usage','off_peak_hours_usage')
                    ->where('customer_type','<>','1')
                    ->where('home_location_code',Auth::user()->home_location_code)
                    ->orderBy('id','desc')->get();
        // $queries = DB::getQueryLog();
        // allQuery($queries);
        // pa($customers);
        // die;

        return DataTables::of($customers)
            
             ->addColumn('action', function ($customer) {
                 return '<a href="/customers/'.$customer->id.'/edit"><i class="fa fa-pencil"></i></a>&nbsp;';
             })
             ->make(true);
     }

     
 


}
