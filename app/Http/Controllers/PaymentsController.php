<?php

namespace App\Http\Controllers;

use App\Payment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        // $this->authorize('all', User::class);
        
 
         $view_elements = [];
         
         $view_elements['page_title'] = 'Payments'; 
         $view_elements['component'] = 'payments'; 
         $view_elements['menu'] = 'payments'; 
         $view_elements['breadcrumbs']['All Payments'] = array("link"=>'/payments',"active"=>'1');
         
 
         $view = viewName('payments.all');
         return view($view, $view_elements);
     }

     public function datatablesAllPayments()
     {
        $payments = DB::table('payments')
                        ->leftJoin('users','payments.customer_id','=','users.id')
                        ->where('users.home_location_code','=',Auth::user()->home_location_code)
                        ->get();


        return DataTables::of($payments)
             ->addColumn('action', function ($payment) {
                 return '<a href="/payments/'.$payment->id.'/edit"><i class="fa fa-pencil"></i></a>';
             })
             ->make(true);
     }
}
