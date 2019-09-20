<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;

class ResourcesController extends Controller
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
        // $this->authorize('all', User::class);
        
        $allResources = Resource::all();

         $view_elements = [];
         
         $view_elements['allResources'] = $allResources; 
         $view_elements['page_title'] = 'Resources'; 
         $view_elements['component'] = 'resources'; 
         $view_elements['menu'] = 'resources'; 
         $view_elements['breadcrumbs']['All Resources'] = array("link"=>'/resources',"active"=>'1');
         
 
         $view = viewName('resources.all');
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
         
        $view_elements['page_title'] = 'Resources'; 
        $view_elements['component'] = 'resources'; 
        $view_elements['menu'] = 'resources'; 
        $view_elements['breadcrumbs']['All Resources'] = array("link"=>'/resources',"active"=>'1');
        

        $view = viewName('resources.add');
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
        $resource = Resource::create([
            'resource_name' => $request->resource_name ,
            'resource_type' => $request->resource_type ,
            // 'location_code' => $request->location_code ,
            'peak_price' => $request->peak_price ,
            'off_peak_price' => $request->off_peak_price ,
        ]);


        $request->session()->flash('success_message', 'New resource created successfully');
        return redirect("/dashboard/resources");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        //
    }
}
