<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use League\Flysystem\Config as LeagueConfig;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_config = Config::get();

        $view_elements = [];
        $view_elements['all_config'] = $all_config ; 
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
        $allRequests = $request->all();
        // pa($allRequests);

        foreach($allRequests['data'] as $r){
            // pa($r); die;
            $config = Config::find($r['id']);
            $config->config_key = $r['config_key'];
            $config->config_value = $r['config_value'];
            $config->save();
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
