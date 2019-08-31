<?php

namespace App\Http\Controllers;

use App\Membership;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class MembershipsController extends Controller
{
    public function index(){
        // $this->authorize('all', User::class);
        
        $allMemberships = Membership::with('customers')->get();

         $view_elements = [];
         
         $view_elements['allMemberships'] = $allMemberships; 
         $view_elements['page_title'] = 'Memberships'; 
         $view_elements['component'] = 'memberships'; 
         $view_elements['menu'] = 'memberships'; 
         $view_elements['breadcrumbs']['All Memberships'] = array("link"=>'/memberships',"active"=>'1');
         
 
         $view = viewName('memberships.all');
         return view($view, $view_elements);
     }

     public function create(){
        $view_elements = [];
         
        $view_elements['page_title'] = 'Memberships'; 
        $view_elements['component'] = 'memberships'; 
        $view_elements['menu'] = 'memberships'; 
        $view_elements['breadcrumbs']['All Memberships'] = array("link"=>'/memberships',"active"=>'1');
        

        $view = viewName('memberships.add');
        return view($view, $view_elements);
     }

     public function store(Request $request){
        // pa($request->all());
        $membership = Membership::create([
            'stripe_product_id' => $request->stripe_product_id ,
            'plan_name' => $request->plan_name ,
            // 'frequency' => $request->frequency ,
            // 'location_code' => $request->location_code ,
            'included_peak_hours' => $request->included_peak_hours ,
            'included_off_peak_hours' => $request->included_off_peak_hours ,
            // 'additional_discounted_hours' => $request->additional_discounted_hours ,
            'play_discount' => $request->play_discount ,
            'food_discount' => $request->food_discount ,
            // 'drinks_discount' => $request->drinks_discount ,
            'events_discount' => $request->events_discount ,
            'monthly_due_on_season' => $request->monthly_due_on_season ,
            'monthly_due_off_season' => $request->monthly_due_off_season 
        ]);


        $request->session()->flash('success_message', 'Nem membership plan created successfully');
        return redirect("/dashboard/memberships");

     }


}
