<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\User;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    
    public function index()
    {
        $this->authorize('all', User::class);
        
       // $users = \App\User::all();
         
        $view_elements = [];
        
        // $view_elements['users'] = $users;
        $view_elements['page_title'] = 'Users'; 
        $view_elements['component'] = 'users'; 
        $view_elements['menu'] = 'users'; 
        $view_elements['breadcrumbs']['Users'] = array("link"=>'/users',"active"=>'1');
        

        $view = viewName('users.all');
        return view($view, $view_elements);
    }
    
    public function create()
    {
        $this->authorize('all', User::class); 
        
        $customer_types = \App\CustomerType::all();
        $locations = Location::all();

        $view_elements = [];
        $view_elements['customer_types'] = $customer_types; 
        $view_elements['locations'] = $locations; 
        $view_elements['page_title'] = 'Users'; 
        $view_elements['component'] = 'users'; 
        $view_elements['menu'] = 'users'; 
        $view_elements['breadcrumbs']['Users'] = array("link"=>'/users',"active"=>'0');
        $view_elements['breadcrumbs']['Add New User'] = array("link"=>'/users',"active"=>'1');
        

        $view = viewName('users.add');
        return view($view, $view_elements);
    }
    
    
    public function store(\Symfony\Component\HttpFoundation\Request $request)
    {
        $this->authorize('all', User::class);
        
        $user = \App\User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'customer_type' => $request->customer_type,
            'home_location_code' => $request->home_location_code,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);
        
       
        
        $request->session()->flash('success_message', 'User created successfully');
        return redirect("/dashboard/users");
        
    }
    
    public function edit($user_id)
    {
        $this->authorize('all', User::class);

        $user = \App\User::find($user_id);
        $customer_types = \App\CustomerType::all();
        $locations = Location::all();
        
        $view_elements = [];
        
        $view_elements['user'] = $user;
        $view_elements['customer_types'] = $customer_types;
        $view_elements['locations'] = $locations; 
        $view_elements['page_title'] = 'Users'; 
        $view_elements['component'] = 'users'; 
        $view_elements['menu'] = 'users'; 
        $view_elements['breadcrumbs']['Users'] = array("link"=>'/users',"active"=>'0');
        $view_elements['breadcrumbs']['Add New User'] = array("link"=>'/users',"active"=>'1');
        

        $view = viewName('users.edit');
        return view($view, $view_elements);
    }
    
    public function update(\Symfony\Component\HttpFoundation\Request $request, $user_id)
    {
        $this->authorize('all', User::class);

        $user = \App\User::find($user_id);
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->home_location_code = $request->home_location_code;
        
        if($request->password!='')
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);

        $user->customer_type = $request->customer_type;
        $user->save();
        
        

        $request->session()->flash('success_message', 'User updated successfully');
        return redirect("/dashboard/users");
        
    }
    
    public function delete(\Symfony\Component\HttpFoundation\Request $request, $user_id)
    {
       $this->authorize('all', User::class);

        $user = \App\User::find($user_id);
        if($user){
            $user->delete();
            
            $request->session()->flash('success_message', 'User deleted successfully');
            return redirect("/dashboard/users");
        }
        else
        {
            $request->session()->flash('error_message', 'User not found');
            return redirect("/dashboard/users");
        }
        

        
    }
    
    
    
    public function changePassword()
    {
       

        $view_elements = [];
        
        $view_elements['page_title'] = 'Change Password'; 
        $view_elements['component'] = 'change_password'; 
        $view_elements['menu'] = 'change_password'; 
        $view_elements['breadcrumbs']['Change Password'] = array("link"=>'/change_password',"active"=>'1');
        

        $view = viewName('users.change_password');
        return view($view, $view_elements);
    }
    
    public function updatePassword(\Symfony\Component\HttpFoundation\Request $request){
        $user_id = \Illuminate\Support\Facades\Auth::user()->id;
        \App\User::find($user_id)
                ->update([
                    'password' =>  \Illuminate\Support\Facades\Hash::make($request->password)
                ]);
        
        
        //logout
        \Illuminate\Support\Facades\Auth::logout();
        
        $request->session()->flash('success_message', 'Password updated successfully. Please login again');
        return redirect("/login");
        

    }
    
    public function upload_pic_form()
    {
        $view_elements = [];
        
        $view_elements['page_title'] = 'Upload Profile Pic'; 
        $view_elements['component'] = 'upload_pic'; 
        $view_elements['menu'] = 'upload_pic'; 
        $view_elements['breadcrumbs']['Upload Pic'] = array("link"=>'/profile/upload_pic',"active"=>'1');
        

        $view = viewName('users.upload_pic');
        return view($view, $view_elements);
    }
    
    public function upload_pic(\Symfony\Component\HttpFoundation\Request $request)
    {
        $request->validate([

            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $imageName = time().'.'.$request->profile_pic->getClientOriginalExtension();

        $request->profile_pic->move(public_path('dist/images'), $imageName);
        $user = \App\User::find(\Illuminate\Support\Facades\Auth::user()->id);
        $user->profile_pic = $imageName;
        $user->save();
        
        \Illuminate\Support\Facades\Auth::setUser($user);
        
        return back()
            ->with('success_message','You have successfully upload image.')
            ->with('profile_pic',$imageName);

    }
    

    public function datatables_all_users()
    {
        $users = \App\User::select(['id','first_name','last_name','email', 'home_location_code'])
                        ->where('home_location_code', Auth::user()->home_location_code)
                        ->get();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="/dashboard/users/'.$user->id.'/edit"><i class="fa fa-pencil"></i></a>';
            })
            ->make(true);
    }

    // ->addColumn('action', function ($user) {
    //     return '<a href="{{ url(\'/users/'.$user->id.'/edit\')}}"><i class="fa fa-pencil"></i></a> &nbsp; 
    //     <a href="{{ url(\'/users/'.$user->id.'/delete\')}}" class="text-danger" onclick=\'return confirm("Are you sure to delete this user?");\'><i class="fa fa-trash text-danger"></i></a>';
    // })
    
}
