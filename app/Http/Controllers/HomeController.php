<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $plan_starts_on = strtotime("2019-01-01");
        // $plan_ends_on = strtotime('+1 year', $plan_starts_on);

        // echo date('Y-m-d', $plan_ends_on);

        // echo $acuity_user_id = config('settings.keys.ACUITY_USER_ID'); 
        // echo $acuity_api_key = config('settings.keys.ACUITY_API_KEY'); 


        // $user = \Illuminate\Support\Facades\Auth::user();
        // $this->authorize('view', \App\User::class);
        // $this->authorize('all', \App\User::class );

      //  $user_id = \Illuminate\Support\Facades\Auth::user()->id;
      // $user = \Illuminate\Support\Facades\Auth::user();

      // $user = \App\User::find($user_id);

        // if ($user->can('manage', User::class)) {
        //     echo "This is Super Admin Section";
        // }
        // else{
        //     echo "NOT VALID CALL";
        // }
            

    //    $this->authorize('manage', User::class);

        $view_elements = [];
        $view_elements['page_title'] = 'Home'; 
        $view_elements['component'] = 'Dashboard'; 
        $view_elements['menu'] = 'dashboard'; 
        $view_elements['breadcrumbs']['Dashboard'] = array("link"=>'/',"active"=>'0');
        
        
      

        $view = viewName('home');
        return view($view, $view_elements);
    }
}
