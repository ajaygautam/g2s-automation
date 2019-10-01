<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Stripe;

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
