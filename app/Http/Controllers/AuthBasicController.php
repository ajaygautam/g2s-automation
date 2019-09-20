<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthBasicController extends Controller
{
    function setPasswordForm($hash){
        return view('set_password', ['hash'=>$hash]);
    }

    function setPassword(Request $request){

        $user = User::where('set_password_hash',$request->hash)->first();
        if($user){
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $request->session()->flash('success_message', 'Password updated successfully. Please login to access the dashboard.');

        return redirect('/dashboard');

    }
}
