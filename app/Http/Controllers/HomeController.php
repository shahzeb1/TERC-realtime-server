<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Cookie;
use Crypt;

class HomeController extends Controller
{
    /**
     * Shows the homepage for not-logged in users
     * @return view 
     */
    public function showHome(){
        $raw = Cookie::get('email');
        if($raw != ""){
            return redirect()->intended('/dashboard');
        }
        $user = Crypt::decrypt($raw);
        return view('home.home');
    }

    /**
     * Return the login view
     * @return view
     */
    public function login(Request $request){
        $email = $request->email;
        $found = DB::table('users')->where('email', '=', $email)->count();
        if($found == 1){
            Cookie::queue('email', $request->email, 120);
            return redirect()->intended('/dashboard');
        }else{
            return redirect()->intended('/home');
        }
    }

    /**
     * Logout the user
     */
    public function logout(){
        Cookie::queue('email', '', -120);
        return redirect()->intended('/');
    }
}
