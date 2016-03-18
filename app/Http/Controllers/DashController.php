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
    	return view('dash.dash');
    }
}
