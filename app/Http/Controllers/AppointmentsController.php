<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HttpHelper;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Yajra\DataTables\Facades\DataTables;
use App\Appointment;
use App\AppointmentResource;
use App\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentsController extends Controller
{
    private $httpAcuity;

    public function __construct()
    {
        $this->middleware('auth');
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

        $appointments = Appointment::with('customer')
                        ->where('acuity_action','scheduled')                        
                        ->orderBy('appointment_date','desc')
                        ->get();
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
        $acuity_user_id = config('settings.keys.ACUITY_USER_ID'); 
        $acuity_api_key = config('settings.keys.ACUITY_API_KEY'); 

        $client = new \GuzzleHttp\Client(['auth' => [$acuity_user_id,$acuity_api_key]]);

        $request = $client->get('https://acuityscheduling.com/api/v1/appointments/'.$appointment_id);
        $appointment = json_decode($request->getBody()->getContents());
        
        // Log::info(json_encode($appointment));

        // pa($appointment); die;

        //Update Customer Table

        $customer = User::where('email',$appointment->email)
                        ->orWhere('email_2',$appointment->email)
                        ->orWhere('email_3',$appointment->email)
                        ->first();
        
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
                'email' => $appointment->email,
                // 'membership_plan_id' => 0,
            ]);
            $customer_id = $customer->id;
        }



        Log::info(format_date($appointment->date,1));
            
        $insertObj = [
            'customer_id' => $customer_id,
            'appointment_date' => format_date($appointment->date,1),
            'appointment_start_time' => format_date($appointment->time,8),
            'appointment_end_time' => format_date($appointment->endTime,8),
            'acuity_action' => $type,
            'is_paid' => $appointment->paid=='no'?"0":"1",
            'price' => $appointment->price,
            'duration' => $appointment->duration,
            'amount_paid' => $appointment->amountPaid,
            'appointment_notes' => $appointment->notes,
            'acuity_appointment_id' => $appointment->id,
            'acuity_appointment_type' => $appointment->appointmentTypeID,
            'acuity_calendar_id' => $appointment->calendarID,
        ];
       
        Log::info($insertObj);
    
        $dbAppointment = Appointment::create($insertObj);

        // Create Appointment Resource
        //Right now, resource_id is 1
        
        AppointmentResource::create([
            'resource_id' => '1',
            'appointment_id' => $dbAppointment->id
        ]);

        Log::info('Webhook data fetched from API');
    }

}
