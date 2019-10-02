<?php

namespace App\Http\Controllers;

use App\Config;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    
        $this->middleware(function ($request, $next) {
            $customer_type= Auth::user()->customer_type;
            if(Auth::user()->customer_type!='1'){
                    $request->session()->flash('error_message', 'Access Denied');
                    return redirect("/dashboard");
            }
            return $next($request);
        });


      
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_location = Location::all();


        $view_elements = [];
        
        $view_elements['all_location'] = $all_location ; 
        $view_elements['page_title'] = 'Locations'; 
        $view_elements['component'] = 'locations'; 
        $view_elements['menu'] = 'locations'; 
        $view_elements['breadcrumbs']['Locations'] = array("link"=>'/location',"active"=>'1');
       
        $view = viewName('locations.all');
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
         
        $view_elements['page_title'] = 'Set up new Locations'; 
        $view_elements['component'] = 'locations'; 
        $view_elements['menu'] = 'locations';
        $view_elements['breadcrumbs']['All Locations'] = array("link"=>'/dashboard/locations',"active"=>'1');
        

        $view = viewName('locations.add');
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
        Location::create([
            'location_name' => $request->location_name,
            'location_code' => $request->location_code,
        ]);


        $request->session()->flash('success_message', 'New location is created successfully');
        return redirect("/dashboard/locations");


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $location = Location::find($location->id);
        
        $view_elements = [];
         
        $view_elements['location'] = $location; 
        $view_elements['page_title'] = 'Set up new Locations'; 
        $view_elements['component'] = 'locations'; 
        $view_elements['menu'] = 'locations';
        $view_elements['breadcrumbs']['All Locations'] = array("link"=>'/dashboard/locations',"active"=>'1');
        
        

        $view = viewName('locations.edit');
        return view($view, $view_elements);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        // $locationObj = Location::find($location->id); 
        $location->location_name = $request->location_name;
        $location->location_code = $request->location_code;
        $location->save();

        $request->session()->flash('success_message', 'Location updated successfully');
        return redirect("/dashboard/locations");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }


    public function loadConfig($location_code)
    {

        // echo  $location_code;

        // die;
        // $location_code = Auth::user()->home_location_code;

        $all_config = Config::where('location_code', $location_code)->get(); 
        
        $config_keys = [] ;
        if($all_config->count()==0){
            $all_config = config('settings.default_config_keys'); 
        }
       
        // $all_config = Config::get();

        $view_elements = [];
        
        // $view_elements['config_keys'] = $config_keys ; 
        $view_elements['all_config'] = $all_config ; 
        $view_elements['customer_type'] = Auth::user()->customer_type; 
        $view_elements['location_code'] = $location_code;

        $view_elements['page_title'] = 'Configuration for location: '.$location_code; 
        $view_elements['component'] = 'config'; 
        $view_elements['menu'] = 'congif'; 

        $view_elements['breadcrumbs']['All Locations'] = array("link"=>'/dashboard/locations',"active"=>'0');
        $view_elements['breadcrumbs'][$location_code.' Configuration'] = array("link"=>'',"active"=>'1');
       
        $view = viewName('config.all');
        return view($view, $view_elements);
    }


    public function saveConfig($location_code, Request $request)
    {
        if(Auth::user()->customer_type!='1'){
            $request->session()->flash('error_message', 'Access Denied');
            return redirect("/dashboard");
        }


        $allRequests = $request->all();
        
        // delete previous config
        $delete = Config::where('location_code', $location_code)->delete();
        
        foreach($allRequests['data'] as $r){
            $config = Config::create([
                'config_key' => $r['config_key'],
                'config_value' => $r['config_value'],
                'location_code' => $location_code,
            ]);
        }

        $request->session()->flash('success_message', 'Configuration updated successfully');
        return redirect("/dashboard/locations/load_config/".$location_code);
      

    }



}
