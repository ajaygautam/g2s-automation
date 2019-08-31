<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Stripe;

class CustomersController extends Controller
{
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

    public function charge($customer_id ,$month=null, $year = null){
        if($month == null){
            $month = date('m');
        }
        if($year == null){
            $year = date('Y');
        }

        $customer = Customer::with('membership','last_visit','peak_hours_usage','off_peak_hours_usage')->where('id',$customer_id)->first();

        $peak_hour_charge = 60; 
        $off_peak_hour_charge = 45;
        $discount_play = 15;  //in percent
        
        $used_peak_hours = $customer->peak_hours_usage[0]->peak_hours_used; 
        $used_off_peak_hours = $customer->off_peak_hours_usage[0]->off_peak_hours_used; 

        if($customer->membership){
         $included_peak_hours = $customer->membership->included_peak_hours;
         $included_off_peak_hours = $customer->membership->included_off_peak_hours;

         $sum = (($used_peak_hours - $included_peak_hours) * $peak_hour_charge) +  (($used_off_peak_hours - $included_off_peak_hours) * $off_peak_hour_charge);
         $final = $sum - ($sum * $discount_play)/100;
        } 
        else{
            $final = (($used_peak_hours) * $peak_hour_charge) +  (($used_off_peak_hours) * $off_peak_hour_charge);
        }    

        // pa($customer);

        // die;
        \Stripe\Stripe::setApiKey('sk_test_MAlyixzobvAPNOmbrf7esLrJ003VDAgXJp');
        \Stripe\Charge::create([
            "amount" => $final,
            "currency" => "usd",
            "customer" => $customer->stripe_customer_id,
            
            "description" => "Additional Play Charges"
          ]);


        echo $final;

    }


     public function datatablesAllCustomers()
     {
        DB::connection()->enableQueryLog();
        $customers = Customer::with('membership','last_visit','peak_hours_usage','off_peak_hours_usage')->orderBy('id','desc')->get();
        $queries = DB::getQueryLog();
        // allQuery($queries);
        // pa($customers);
        // die;

        return DataTables::of($customers)
            //  ->addColumn('membership', function ($customer) {
            //      return $customer->membership->plan_name;
            //  })
            
            // ->addColumn('usage', function ($customer) {
            //     return count($customer->last_visit)>0? format_date($customer->last_visit->appointment_date,2).' - '.format_date($customer->last_visit->appointment_start_time,4): ' - ';
            // })
            
            // ->addColumn('last_visit', function ($customer) {
            //     return $customer->last_visit!='' ? format_date($customer->last_visit->appointment_date,2).' - '.format_date($customer->last_visit->appointment_start_time,4): ' - ';
            // })
            
            //  ->addColumn('charge', function ($customer) {
            //      return '<a href="/customers/'.$customer->id.'/edit"><i class="fa fa-dollar"></i></a>';
            //  })
             ->addColumn('action', function ($customer) {
                 return '<a href="/customers/'.$customer->id.'/edit"><i class="fa fa-pencil"></i></a>&nbsp;
                 <a href="/customers/'.$customer->id.'/edit"><i class="fa fa-dollar"></i></a>';
             })
             ->make(true);
     }
 


}
