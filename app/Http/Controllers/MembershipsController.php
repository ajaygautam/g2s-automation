<?php

namespace App\Http\Controllers;

use App\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class MembershipsController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }

    public function index(){
        // $this->authorize('all', User::class);
        
        // $allMemberships = Membership::with('customers')->get();
        $allMemberships = Membership::all();

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
         
        $view_elements['location_code'] = Auth::user()->home_location_code; 

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
            'plan_name' => $request->plan_name ,
            'frequency' => $request->frequency ,
            // 'location_code' => $request->location_code ,
            'included_peak_hours' => $request->included_peak_hours ,
            'included_off_peak_hours' => $request->included_off_peak_hours ,
            'included_lessons' => $request->included_lessons ,
            'play_discount' => $request->play_discount ,
            'food_discount' => $request->food_discount ,
            'events_discount' => $request->events_discount ,
            'monthly_due_on_season_yc' => $request->monthly_due_on_season_yc,
            'monthly_due_off_season_yc' => $request->monthly_due_off_season_yc,
            'monthly_due_on_season_mc' => $request->monthly_due_on_season_mc,
            'monthly_due_off_season_mc' => $request->monthly_due_off_season_mc,
            'plan_type' => $request->plan_type ,
            'tax_exemption' => $request->tax_exemption ,
            'location_code' => $request->location_code ,
            
        ]);

        $plan_code_seed = $membership->id.strtotime($membership->created_at);
        $membership->plan_code = base64_encode($plan_code_seed);    
        $membership->save();    

        $request->session()->flash('success_message', 'New membership plan created successfully');
        return redirect("/dashboard/memberships");

     }

     public function edit($membership_plan_id){
        $membership = Membership::find($membership_plan_id);

        $view_elements = [];
         
        $view_elements['membership'] = $membership; 
        $view_elements['page_title'] = 'Memberships'; 
        $view_elements['component'] = 'memberships'; 
        $view_elements['menu'] = 'memberships'; 
        $view_elements['breadcrumbs']['All Memberships'] = array("link"=>'/memberships',"active"=>'1');
        $view_elements['breadcrumbs'][$membership->plan_name] = array("link"=>'/memberships',"active"=>'0');

        $view = viewName('memberships.edit');
        return view($view, $view_elements);

     }

     public function update($membership_plan_id, Request $request){

        $membership = Membership::find($membership_plan_id);
        $membership->plan_name = $request->plan_name ;
        $membership->frequency = $request->frequency ;
        // $membership->location_code = $request->location_code ;
        $membership->included_peak_hours = $request->included_peak_hours ;
        $membership->included_off_peak_hours = $request->included_off_peak_hours ;
        $membership->included_lessons = $request->included_lessons ;
        $membership->play_discount = $request->play_discount ;
        $membership->food_discount = $request->food_discount ;
        $membership->events_discount = $request->events_discount ;
        $membership->monthly_due_on_season_yc = $request->monthly_due_on_season_yc ;
        $membership->monthly_due_off_season_yc = $request->monthly_due_off_season_yc;
        $membership->monthly_due_on_season_mc = $request->monthly_due_on_season_mc ;
        $membership->monthly_due_off_season_mc = $request->monthly_due_off_season_mc;
        $membership->plan_type = $request->plan_type ;
        $membership->tax_exemption = $request->tax_exemption ;
        $membership->location_code = $request->location_code ;

        if($membership->plan_code==''){
            $plan_code_seed = $membership->id.strtotime($membership->created_at);
            $membership->plan_code = base64_encode($plan_code_seed);    
        }
        $membership->save();    

        $request->session()->flash('success_message', 'Membership plan updated successfully');
        return redirect("/dashboard/memberships");

     }


}
