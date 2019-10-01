<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Config as LeagueConfig;

class ConfigController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        // pa(Auth::user());
        // die;

        // if(Auth::user()->customer_type!='1'){
        //     $request->session()->flash('error_message', 'Access Denied');
        //     return redirect("/dashboard");
        // }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $location_code = Auth::user()->home_location_code;

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

        $view_elements['page_title'] = 'Configuration'; 
        $view_elements['component'] = 'config'; 
        $view_elements['menu'] = 'congif'; 
        $view_elements['breadcrumbs']['Configuration'] = array("link"=>'/config',"active"=>'1');
       
        $view = viewName('config.all');
        return view($view, $view_elements);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->customer_type!='1'){
            $request->session()->flash('error_message', 'Access Denied');
            return redirect("/dashboard");
        }


        $allRequests = $request->all();
        
        $location_code = Auth::user()->home_location_code;

        $delete = Config::where('location_code', $location_code)->delete();
        

        foreach($allRequests['data'] as $r){
            $config = Config::create([
                'config_key' => $r['config_key'],
                'config_value' => $r['config_value'],
                'location_code' => $location_code,
            ]);
        }

        $request->session()->flash('success_message', 'Configuration updated successfully');
        return redirect("/dashboard/config");
      

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function show(Config $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function edit(Config $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Config $config)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function destroy(Config $config)
    {
        //
    }
}
