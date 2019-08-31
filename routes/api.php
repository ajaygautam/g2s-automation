<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\StripeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/acuity_post', function(Request $request){
    Log::info('reached the route');
    Log::info(json_encode($request->all()));

    $req = $request->all();
    $appointment_id = $req['id'];
    // Log::info(json_encode($request->all()));
    AppointmentsController::dumpAppointmentsIntoDB($appointment_id, $req['action']);
});



Route::get('/acuity_post', function(Request $request){
    Log::info('reached the route');
    $appointment_id = '312317941';
    Log::info(json_encode($request->all()));
    AppointmentsController::dumpAppointmentsIntoDB($appointment_id,'scheduled');
});

Route::post('/stripe_handler', function(Request $request){
    Log::info('reached the route');
    $payload = json_encode($request->all());
    StripeController::StripePostStatic($payload);
    Log::info($payload);
});
Route::get('/stripe_handler', function(Request $request){
    Log::info('reached the route');
});




Route::post('/users/register', 'Api\ApiUsersController@register');
Route::post('/users/login', 'Api\ApiUsersController@login');
