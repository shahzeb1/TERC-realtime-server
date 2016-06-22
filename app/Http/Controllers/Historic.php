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
    	$user = Crypt::decrypt($raw);
    	$lists = ['c_rock', 'rubicon', 'sunny_side', 't_cove', 't_vista', 'tdr1', 'tdr2', 'usgs'];
    	return view('docs.historicOptions', ['lists' => $lists]);
    }

    public function showHistoricFor($name){
    	$raw = Cookie::get('email');
    	$user = Crypt::decrypt($raw);
    	$key = md5($user);
    	$lists = ['c_rock', 'rubicon', 'sunny_side', 't_cove', 't_vista', 'tdr1', 'tdr2', 'usgs'];
    	return view('docs.historicAPIView', ['lists' => $lists, 'key' => $key, 'name' => $name]);
    }

    public function showHomewood(){
        $raw = Cookie::get('email');
        $user = Crypt::decrypt($raw);
        $key = md5($user);
        return view('docs.homewoodAPIView', ['key' => $key]);
    }

    public function showNASA(){
        $raw = Cookie::get('email');
        $user = Crypt::decrypt($raw);
        $key = md5($user);
        return view('docs.nasaAPIView', ['key' => $key]);
    }


}
