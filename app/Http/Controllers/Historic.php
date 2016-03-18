<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cookie;
use Crypt;

class Historic extends Controller
{
    public function showOptions(){
    	$raw = Cookie::get('email');
		if($raw == ""){
    		return redirect()->intended('/');
    	}
    	$user = Crypt::decrypt($raw);
    	$lists = ['c_rock', 'rubicon', 'sunny_side', 't_cove', 't_vista', 'tdr1', 'tdr2', 'usgs'];
    	return view('realtime.options', ['lists' => $lists]);
    }

    public function showHistoricFor($name){
    	$raw = Cookie::get('email');
		if($raw == ""){
    		return redirect()->intended('/');
    	}
    	$user = Crypt::decrypt($raw);
    	$key = md5($user);

    	$lists = ['c_rock', 'rubicon', 'sunny_side', 't_cove', 't_vista', 'tdr1', 'tdr2', 'usgs'];
    	return view('realtime.historicAPIView', ['lists' => $lists, 'key' => $key, 'name' => $name]);
    }
}
