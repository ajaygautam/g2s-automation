<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerPlan;
use App\FoodDrinksCharge;
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
             'first_name' => 'required',
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
  
        $chargable_amount = StripeController::CalculateChargeableAmount([
            'email' => $request->primary_email,
            'membership' => $membership,
            'request' => $request
        ]);

 
        if($chargable_amount > 0){
            try{
                $customer = StripeController::GetStripeCustomer([
                    'stripeToken' => $stripeToken,
                    'name' => $request->first_name.' '.$request->last_name,
                    'email' => $request->primary_email,
                    'membership' => $membership,
                    'request' => $request,
                ]);
         
                $payment = StripeController::StripeCharge([
                    'customer' => $customer,
                    'amount' => $chargable_amount,
                    'request' => $request,
                ]);
                
                $request->session()->flash('success_message', 'New customer is created successfully');
                return redirect("/dashboard/customers");
            }catch(Exception $e){
               return throwExpection($e);
            } 
        }

        
    }


    public function datatablesAllCustomers()
    {
        if(Auth::user()->customer_type=='1'){
            $customers = User::with('customerPlan','membership','peak_hours_usage','off_peak_hours_usage')
                ->where('customer_type','=','4')
                ->orderBy('id','desc')->get();
        }
        else{
            $customers = User::with('customerPlan','membership','peak_hours_usage','off_peak_hours_usage')
                ->where('customer_type','=','4')
                ->where('home_location_code',Auth::user()->home_location_code)
                ->orderBy('id','desc')->get();
        }




 
        return DataTables::of($customers)
            
             ->addColumn('action', function ($customer) {
                 return '<a href="/dashboard/customers/'.$customer->id.'/edit" title="Edit Customer"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/dashboard/customers/charge/'.$customer->id.'" title="Create Charge"><i class="fa fa-dollar"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/dashboard/customers/add_food_drink_charges/'.$customer->id.'"><i class="fa fa-cutlery" title="Add Food and Drinks Charges"></i></a>&nbsp;';
             })
             ->make(true);
     }

              /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($customer_id, Request $request)
    {

        $customer = User::with('membership','customerPlan','peak_hours_usage','off_peak_hours_usage')->where('id', $customer_id)->first();

        $view_elements = [];

        $membership_plans = Membership::all();
         
         $view_elements['page_title'] = 'Add Customer'; 
         $view_elements['plans'] = $membership_plans; 
         $view_elements['customer'] = $customer; 
         $view_elements['component'] = 'customers'; 
         $view_elements['menu'] = 'customers'; 
         $view_elements['breadcrumbs']['All Customers'] = array("link"=>'/customers',"active"=>'0');
         $view_elements['breadcrumbs']['Add New Customer'] = array("link"=>'/customers',"active"=>'1');
         
 
         $view = viewName('customers.edit');
         return view($view, $view_elements);
    }
     
    public function update($customer_id, Request $request){
        $allRequests = $request->all();

        $validatedData = $request->validate([
                'first_name' => 'required',
                'primary_email' => 'required|email',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'referral' => 'required',
                'referral_other' => 'sometimes|required',
               
            ],
            [
                'referral_other.required' => 'Referred by Other is required',
                
            ]
        );

        $membership = Membership::find($request->membership_plan_id);
        
        $customer = User::find($customer_id);
        $customer->email = $request->primary_email;

        if($request->password!='')
            $customer->password = bcrypt($request->password);
        

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->primary_email;
        $customer->email_2 = $request->email_2;
        $customer->email_3 = $request->email_3;
        $customer->phone_1 = $request->phone_1;
        $customer->phone_2 = $request->phone_2;
        $customer->phone_3 = $request->phone_3;

        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->state = $request->state;
        $customer->county = $request->county;
        $customer->country = $request->country;
        $customer->zipcode = $request->zipcode;
        $customer->save();

        //Some entries in CustomerPlan

         
        $customerPlan = CustomerPlan::where('customer_id', $customer_id)->first();
        $customerPlan->referral =  $request->referral;
        $customerPlan->referral_other =  $request->referral_other;
        $customerPlan->save();



        $request->session()->flash('success_message', 'Customer details updated successfully');
        return redirect("/dashboard/customers/".$customer_id."/edit");


    }


    public function updateMembership($customer_id, Request $request){
       
        $customerPlan = CustomerPlan::where('customer_id', $customer_id)->first();
        $customerPlan->membership_plan_id =  $request->membership_plan_id;
        $customerPlan->plan_starts_on =  $request->plan_starts_on ;
        $customerPlan->yearly_commitment =  $request->yearly_commitment;
        $customerPlan->is_plan_hold =  $request->is_plan_hold;
        
        if($request->is_plan_hold==0 && $customerPlan->plan_hold_starts_on!=''){
            $customerPlan->plan_hold_ends_on = date('Y-m-d'); 
        }

        if($request->is_plan_hold ==1){
            $customerPlan->plan_hold_starts_on = date('Y-m-d'); 
            $customerPlan->plan_hold_ends_on = null; 
        }
        $customerPlan->save();

        
        $request->session()->flash('success_message', 'Customer membership details updated successfully');
        return redirect("/dashboard/customers/".$customer_id."/edit");

    }

    public function updateCard($customer_id, Request $request){
        
        $customer = User::with('membership')->where('id',$customer_id)->first();
        $membership = $customer->membership[0];
        
        $stripe_secret = config('settings.keys.STRIPE_SECRET');
        Stripe::setApiKey($stripe_secret);

        $stripeToken = $request->stripeToken;
          
        
        //Membership cost
        $chargable_amount = StripeController::CalculateChargeableAmount([
            'email' => $request->primary_email,
            'membership' => $membership,
            'request' => $request
        ]);


        if($chargable_amount > 0 && $request->charge_customer=='1'){
           
            //Update Card comment
            $request->stripe_charge_comment = "Update Card";
           
            try{
                 $payment = StripeController::StripeCharge([
                    'customer' => $customer,
                    'amount' => $chargable_amount,
                    'request' => $request,
                ]);
                
            }catch(Exception $e){
               return throwExpection($e);
            }

       }

       $request->session()->flash('success_message', 'Customer payment details updated successfully');
       return redirect("/dashboard/customers/".$customer_id."/edit");
   
    }

    public function chargeForm($customer_id, Request $request){
        $customer = User::find($customer_id);
        
        $view_elements = [];
         
        $view_elements['customer'] = $customer; 
        $view_elements['page_title'] = 'Customers'; 
        $view_elements['component'] = 'customers'; 
        $view_elements['menu'] = 'customers'; 
        $view_elements['breadcrumbs']['All Customers'] = array("link"=>'/customers',"active"=>'1');
        

        $view = viewName('customers.charge');
        return view($view, $view_elements);  
    }

    public function processCharge($customer_id, Request $request){
        $customer = User::find($customer_id);

        try{
            $payment = StripeController::StripeCharge([
               'customer' => $customer,
               'amount' => $request->charge_amount,
               'request' => $request,
               'comments' => $request->comments
           ]);
           
       }catch(Exception $e){
          return throwExpection($e);
       }

       $request->session()->flash('success_message', 'Customer charged successfully');
       return redirect("/dashboard/customers/");
    }


    public function addFoodDrinkCharges($customer_id){
        $customer = User::with('food_drink_charges_monthly_total','food_drink_charges')->where('id', $customer_id)->first();

        // pa($customer);
        // die;

        $view_elements = [];

         
         $view_elements['page_title'] = 'Food and Drinks Charges'; 
         $view_elements['customer'] = $customer; 
         $view_elements['component'] = 'customers'; 
         $view_elements['menu'] = 'customers'; 
         $view_elements['breadcrumbs']['All Customers'] = array("link"=>'/customers',"active"=>'0');
         $view_elements['breadcrumbs']['Edit Customer'] = array("link"=>'/customers',"active"=>'1');
         
 
         $view = viewName('customers.food_drink_cost');
         return view($view, $view_elements);
    }

    public function saveFoodDrinkCharges($customer_id, Request $request){
        $validatedData = $request->validate([
            'cost' => 'required',
            'consumed_on' => 'required|date_format:Y-m-d',
            'description' => 'required',
            ]);

      
      
        FoodDrinksCharge::create([
            'cost' => $request->cost,
            'consumed_on' => $request->consumed_on,
            'description' => $request->description,
            'customer_id' => $customer_id
        ]);
         
        $request->session()->flash('success_message', 'Food and drink charges added successfully');
        return redirect("/dashboard/customers/add_food_drink_charges/". $customer_id);
    }

    public function deleteFoodDrinkCharges($charge_id, Request $request){
        $foodCharge =  FoodDrinksCharge::find($charge_id);
        $customer_id =  $foodCharge->customer_id;
        $foodCharge->delete();
        
        $request->session()->flash('success_message', 'Charge deleted successfully');
        return redirect("/dashboard/customers/add_food_drink_charges/". $customer_id);

    }


 


}
