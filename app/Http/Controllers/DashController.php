<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cookie;
use Crypt;

class DashController extends Controller
{
	/**
	 * Dashboard, just show it
	 * @return [type] [description]
	 */
    public function showDash(){
    	$raw = Cookie::get('email');
		if($raw == ""){
    		return redirect()->intended('/');
    	}
    	$user = Crypt::decrypt($raw);
    	
    	return view('dash.dash');
    }
}
