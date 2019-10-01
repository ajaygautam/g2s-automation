<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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
        //
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
        //
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
}
