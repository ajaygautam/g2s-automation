<?php

namespace App\Http\Controllers\API;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Resource;
use App\User;

class ApiCustomerController extends Controller
{
    public function getCustomerDetails($customer_id){
       
        // $customer = Customer::with('membership','last_visit','peak_hours_usage','off_peak_hours_usage')->where('id',$customer_id)->first();
        $customer = User::with('customerPlan','membership','peak_hours_usage','off_peak_hours_usage')->where('id',$customer_id)->first();

        $resource = Resource::find('1');    
        $peak_hour_charge = $resource->peak_price; 
        $off_peak_hour_charge = $resource->off_peak_price;
        $chargable_amount = 0;


        if(count($customer->membership)>0)
            {
                if($customer->membership[0]->frequency == 0){
                   //fetch discount 
                    $discount_play = $customer->membership[0]->play_discount;  //in percent
                
                    $used_peak_hours = $used_off_peak_hours = 0;
                
                    if(count($customer->peak_hours_usage)){
                        $used_peak_hours = ($customer->peak_hours_usage[0]->peak_hours_used); // covert minutes to hours
                    }
                    if(count($customer->off_peak_hours_usage)){
                        $used_off_peak_hours = ($customer->off_peak_hours_usage[0]->off_peak_hours_used); //convert minutes to hours
                    }
                
                    $included_peak_hours = $customer->membership[0]->included_peak_hours;
                    $included_off_peak_hours = $customer->membership[0]->included_off_peak_hours;
    
                    $additional = (($used_peak_hours - $included_peak_hours) * $peak_hour_charge) +  (($used_off_peak_hours - $included_off_peak_hours) * $off_peak_hour_charge);
                    $additional_final = $additional - ($additional * $discount_play)/100;
        
                    if($additional_final>0){
                        $chargable_amount = $customer->membership[0]->cost + $additional_final;
                    }
                    else{
                        $chargable_amount = $customer->membership[0]->cost;
                    }
                    
                       
                } //frequency==0

               
            }

        $customer->chargable_amount = $chargable_amount;    

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
