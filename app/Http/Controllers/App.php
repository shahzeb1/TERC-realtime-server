<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cookie;
use Crypt;

class App extends Controller
{
    public function showOptions(){
    	$raw = Cookie::get('email');
    	$user = Crypt::decrypt($raw);
    	$lists = ['users', 'algae', 'beach', 'species', 'water'];
    	return view('docs.appOptions', ['lists' => $lists]);
    }

    public function showApp($name){
    	    	$raw = Cookie::get('email');
    	$user = Crypt::decrypt($raw);
    	$key = md5($user);
    	$lists = ['users', 'algae', 'beach', 'species', 'water'];
    	return view('docs.appAPIView', ['lists' => $lists, 'key' => $key, 'name' => $name]);
    }
}
