<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Aws\S3\S3Client;
use Cookie;
use Crypt;

class Realtime extends Controller
{
	public function showRealtimeFor($name){
        $raw = Cookie::get('email');
    	$user = Crypt::decrypt($raw);
    	$list = ['C_Rock', 'Rubicon', 'Sunnyside', 'TDR1', 'TDR2', 'T_Vista', 'USCG'];
    	$key = md5($user);
    	return view('docs.apiView', ['key'=>$key, 'name'=>$name, 'lists' => $list]);
	}

    public function showRealtime(){
        $raw = Cookie::get('email');
    	$user = Crypt::decrypt($raw);
		$list = ['C_Rock', 'Rubicon', 'Sunnyside', 'TDR1', 'TDR2', 'T_Vista', 'USCG'];
    	return view('docs.realtime', ['lists' => $list]);
    }
}
