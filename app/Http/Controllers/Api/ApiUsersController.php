<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;


class ApiUsersController extends Controller
{

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $user = \App\User::where('id', $user->id)->first();
            
            $oauth_client = \App\oAuthClient::where('user_id', $user->id)->first();
            
            
            
            
            
            $response = array(
                'status' => 'true',
                'message' => 'Login successfull',
                'data' => array(
                    'user'=> $user,
                    'client_id'=>$oauth_client->id,
                    'client_secret'=>$oauth_client->secret,
                ),
                'token' => $user->createToken($user->name)->accessToken
            );

            return response()->json($response, '200');
        }
        else{
            return response()->json([
                'status'=>'false',
                'message' =>'The username or password you have entered is invalid.'
            ], 401);
        }
    }
}
