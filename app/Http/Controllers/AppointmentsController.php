<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HttpHelper;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Yajra\DataTables\Facades\DataTables;
use App\Appointment;
use App\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentsController extends Controller
{
    private $httpAcuity;

    public function __construct()
    {
        $this->httpOauth = new HttpHelper();
    }

    public function index(){
       // $this->authorize('all', User::class);
        
       

        $view_elements = [];
        
        $view_elements['page_title'] = 'Apointments'; 
        $view_elements['component'] = 'appointments'; 
        $view_elements['menu'] = 'appointments'; 
        $view_elements['breadcrumbs']['All Appointments'] = array("link"=>'/appointments',"active"=>'1');
        

        $view = viewName('appointments.all');
        return view($view, $view_elements);
    }
    
    public function datatables_all_appointments()
    {
        // $client = new \GuzzleHttp\Client(['auth' => ['17991306','8943a1c9176ca6aac7db3a1231514ebe']]);
        // $request = $client->get('https://acuityscheduling.com/api/v1/appointments');
        // $appointments = json_decode($request->getBody()->getContents());
        // echo '<pre>';
        // print_r($appointments);
        // exit;

        // DB::connection()->enableQueryLog();

        $appointments = Appointment::with('customer')->orderBy('appointment_date','desc')->get();
        // $queries = DB::getQueryLog();
        //  allQuery($queries);

        // die;

        return DataTables::of($appointments)
            ->addColumn('action', function ($appointment) {
                return '<a href="/appointments/'.$appointment->id.'/edit"><i class="fa fa-pencil"></i></a>';
            })
            ->make(true);
    }


    public static function dumpAppointmentsIntoDB($appointment_id, $type)
    {
        $client = new \GuzzleHttp\Client(['auth' => ['18168916','e884c92a5192058a3b473b15cef6b269']]);
        $request = $client->get('https://acuityscheduling.com/api/v1/appointments/'.$appointment_id);
        $appointment = json_decode($request->getBody()->getContents());
        

        // pa($appointment); die;

        //Update Customer Table

        $customer = Customer::where('primary_email',$appointment->email)->first();
        
        if($customer){
            if($customer->first_name==''){
                $customer->first_name = $appointment->firstName;
                $customer->last_name = $appointment->lastName;
                $customer->save();
            }

            $customer_id = $customer->id;
        }
        else{
            $customer = Customer::create([
                'first_name' => $appointment->firstName,
                'last_name' => $appointment->lastName,
                'primary_email' => $appointment->email,
                'membership_plan_id' => 0,
            ]);
            $customer_id = $customer->id;
        }

        pa([
            'first_name' => $appointment->firstName,
            'last_name' => $appointment->lastName,
            'phone_number' => $appointment->phone,
            'email' => $appointment->email,
            'appointment_date' => format_date($appointment->date,1),
            'appointment_start_time' => format_date($appointment->time,8),
            'appointment_end_time' => format_date($appointment->endTime,8),
            'paid' => $appointment->paid,
            'price' => $appointment->price,
            'acuity_appointment_id' => $appointment->id,
        ]);

        Log::info(format_date($appointment->date,1));
        Log::info([
            'customer_id' => $customer_id,
            'appointment_date' => format_date($appointment->date,1),
            'appointment_start_time' => format_date($appointment->time,8),
            'appointment_end_time' => format_date($appointment->endTime,8),
            'is_paid' => $appointment->paid,
            'amount' => $appointment->price,
            'acuity_appointment_id' => $appointment->id,
        ]);


        $peak_days = ['Fri', 'Sat', 'Sun'];
        $off_peak_days = ['Mon', 'Tue', 'Wed', 'Thu'];

        $time1 = strtotime(format_date($appointment->time,8));
        $time2 = strtotime(format_date($appointment->endTime,8));    
        $usage = round(abs($time2 - $time1) / 3600,2);

        Log::info('usage==>'. $usage);
        Log::info('acuity_action==>'. $type);

        $current_day =  format_date($appointment->date,10);

        if(in_array($current_day, $peak_days)){
            $peak_hours_used  = $usage;
            $off_peak_hours_used  = 0;
        }
        else if(in_array($current_day, $off_peak_days)){
            $peak_hours_used  = 0;
            $off_peak_hours_used  = $usage;
        }
        // echo ; die;
        


        //if($type=='scheduled'){


        // die('create dead for now');    
            Appointment::create([
                'customer_id' => $customer_id,
                'appointment_date' => format_date($appointment->date,1),
                'appointment_start_time' => format_date($appointment->time,8),
                'appointment_end_time' => format_date($appointment->endTime,8),
                'acuity_action' => $type,
                'peak_hours_used' => $peak_hours_used,                
                'off_peak_hours_used' => $off_peak_hours_used,                
                'is_paid' => $appointment->paid,
                'amount' => $appointment->price,
                'acuity_appointment_id' => $appointment->id,
            ]);
        
        
        Log::info('Webhook data fetched from API');
    }

}
