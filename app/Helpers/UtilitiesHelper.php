<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

function create_breadcrumbs($nav_array)
{
    
						
    $nav ='';
    $nav .=''
            . '
                    <ol class="breadcrumb">';
    $nav .='<li><a href="/"><i class="fa fa-dashboard"></i>Dashboard</a></li>';
    
    foreach($nav_array as $key=>$value)
    {
        if($value['active']=='1')
        {
            $class = 'class="active"';
            $nav .='<li '.$class.'>'.$key.'</li>';
        }
        else
        {
            $class = '';
            $nav .='<li '.$class.'><a href="'.$value['link'].'">'.$key.'</a></li>';
        }
        
        
    }
    $nav .='</ol>'
            ;
        
    echo $nav;
}


function lastQuery($queries)
{
    $last_query = end($queries);
    $bindings = array();
    
    foreach($last_query['bindings'] as $b)
    {
        $bindings[] = "'".$b."'";
    }
    
    return str_replace_array('?',$bindings, $last_query['query']);
}

function allQuery($queries)
{
    
    foreach($queries as $query){
        $bindings = array();

        foreach($query['bindings'   ] as $b)
        {
            $bindings[] = "'".$b."'";
        }
       echo str_replace_array('?',$bindings, $query['query']).'<br />'; 
    }
    
    
    // return str_replace_array('?',$bindings, $last_query['query']);
}

function pa($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}


function format_date($date,$type=null, $timezone = null)
{
    switch($type)
    {
        case 1:
        default:
            {
                $datetime = new DateTime($date);
                $new_date = $datetime->format('Y-m-d');// return a date in format like JAN 01 2009
                break;
            }
        case 2:
            {
                $datetime = new DateTime($date);
                $new_date = $datetime->format('M d, Y');// return a date in format like JAN 01 2009
                break;
            }
        case 3:
            {
                $datetime = new DateTime($date);
                $new_date = $datetime->format('M d, Y H:i A ');// return a date in format like 14:45 JAN 01
                break;
            }
        case 4:
            {
                $datetime = new DateTime($date);
                $new_date = $datetime->format('H:i A ');// return a date in format like 14:45 JAN 01
                break;
            }
             case 5:
            {
                $datetime = new DateTime($date);
                $new_date = $datetime->format('Y-m-d H:i:s');// return a date in format like 14:45 JAN 01
                break;
            }
             case 6:
            {
                $datetime = new DateTime($date);
                $new_date = $datetime->format('Y-m-d 23:59:59');// return a date in format like 14:45 JAN 01
                break;
            }
             case 7:
            {
                $datetime = new DateTime($date);
                $new_date = $datetime->format('M d');// return a date in format like JAN 01 2009
                break;
            }
             case 8:
            {
                $datetime = new DateTime($date);
                $new_date = $datetime->format('H:i:s');// return a date in format like JAN 01 2009
                break;
            }
            case 9:{
                
                $datetime = new DateTime($date);
                $date = $datetime->format('Y-m-d H:i:s');// return a date in format like JAN 01 2009
                $new_date = \Snscripts\Timezones\Timezones::convertToLocal($date, $timezone, 'M d, Y H:i A');       
                break;
            }
            case 10:{
                $datetime = new DateTime($date);
                $new_date = $datetime->format('D');// return a day name like Mon, Tue
                break;
            }

    }

    return $new_date;
}


function isPeakMonth($peak_month_starts, $off_peak_month_starts, $current_month = null){

    if($current_month==null){
        $current_month = date('n');
    }

    $peak = new DateTime($peak_month_starts);
    $peak_start = $peak->format('n');
    
    $off = new DateTime($off_peak_month_starts);
    $off_start = $off->format('n');

    $i = $peak_start; $peak_months  = [];
    
    // while($i != $off_start)    
    // {
    //     Log::info('i==>'. $i);
    //     if($i==13){
    //         $i = 1;
    //     }
    //     $peak_months[] = $i;
    //     $i++;     
    // }


    return 1;

    if(in_array($current_month,$peak_months)){
       return 1;
    }
    return 0;
}



function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}

function get_timezones()
{
    $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
          date_default_timezone_set($zone);
          $zones_array[$key]['zone'] = $zone;
          $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
     return $zones_array;   
}


 function checkPermission($user_group_id,$element,$title, $component = 'backend')
    {
             $permission = DB::table('user_group_permissions as up')
                            ->leftJoin('permissions as p','p.id','=','up.permission_id')
                            ->where('up.user_group_id',$user_group_id)
                            ->where('p.element',$element)
                            ->where('p.title',$title)
                            ->count();
            
            if($permission>0)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }

    }

    function viewName($view)
    {
        $view_folder = env('VIEW_FOLDER');
        return $view_folder.'.'.$view;

    }

    function throwExpection($e){
        Log::info($e->getMessage());
        $error = $e->getMessage();
        Session::flash('error_message', $error);
        return Redirect::back();
        exit;
    }


?>