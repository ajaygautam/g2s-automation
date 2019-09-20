<?php

use App\Membership;
use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm' );

Route::get('/passwordhash', function(){
    echo Hash::make('billionaire');
});



Auth::routes();

Route::prefix('dashboard')->group(function () {

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');


    //Users
    Route::resource('users', 'UsersController');
    Route::get('/change_password','UsersController@changePassword');
    Route::post('/update_password','UsersController@updatePassword');
    Route::get('/profile/upload_pic','UsersController@upload_pic_form');
    Route::post('/profile/upload_pic','UsersController@upload_pic');
    Route::get('/users/{user_id}/delete','UsersController@delete');

    Route::get('users/dt/all_users','UsersController@datatables_all_users');


    //Appointments
    Route::get('/appointments','AppointmentsController@index');
    Route::get('appointments/dt/all_appointments','AppointmentsController@datatables_all_appointments');

    //Customers
    Route::get('/customers','CustomersController@index');
    Route::get('customers/dt/all_customers','CustomersController@datatablesAllCustomers');

    //Payments
    Route::get('/payments','PaymentsController@index');
    Route::get('payments/dt/all_payments','PaymentsController@datatablesAllPayments');

    //memberships
    Route::resource('/memberships','MembershipsController' );

    // Route::get('/memberships','MembershipsController@index');
    // Route::get('/memberships/create','MembershipsController@create');
    // Route::post('/memberships','MembershipsController@store');
    Route::get('memberships/dt/all_memberships','MembershipsController@datatablesAllMemberships');

    //Resources
    // Route::get('/resources','MembershipsController@index');
    // Route::get('/memberships/create','MembershipsController@create');
    // Route::post('/memberships','MembershipsController@store');
    Route::resource('/resources','ResourcesController' );
    

    //config
    Route::get('/config','ConfigController@index');
    Route::post('/config','ConfigController@store');
    

    //TEST STRIPE CONTROLLER
    Route::get('/stripe_subscription','StripeController@StripeSubscription');
    Route::post('/stripe_subscription','StripeController@StripeSubscriptionPost');
    Route::get('/stripe_to_db','StripeController@StripePost');
    Route::get('/charge/{month?}/{year?}','StripeController@charge');




});

Route::post('/stripe_subscription','StripeController@StripeSubscriptionPost');
Route::get('/charge','StripeController@charge');

Route::get('payment_form/{plan_code}', function($plan_code){
    $plan = Membership::where('plan_code',$plan_code)->first();
    $data = [];
    $data['plan'] = $plan;
    $data['tax'] = config('settings.tax');
    return view('payment_form', $data);
});

Route::get('payment_success/{payment_id}', 'StripeController@paymentSuccessPage');
Route::get('set_password/{token}', 'AuthBasicController@setPasswordForm');
Route::post('set_password', 'AuthBasicController@setPassword');