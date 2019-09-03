<?php

namespace App\Http\Controllers\API;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiCustomerController extends Controller
{
    public function getCustomerDetails($customer_id){
       
        $customer = Customer::with('membership','last_visit','peak_hours_usage','off_peak_hours_usage')->where('id',$customer_id)->first();
       
        $response = [
            'status_code' => '200',
            'message' => 'Success',
            'data' => $customer,
        ];
       
        return response([
                        'status_code' => '200',
                        'message' => 'Success',
                        'data' => $customer,
                    ],200)
                ->withHeaders(['Content-Type' => 'application/json']
            );
    }
}
