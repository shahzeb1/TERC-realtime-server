<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Cookie;
use Crypt;
use Input;

class HomeController extends Controller
{
    /**
     * Shows the homepage for not-logged in users
     * @return view 
     */
    public function showHome(Request $request){
        return view('home.home');
    }

    public function newUser(Request $request){
        $email = $request->input('email');
        $key = md5($email);
        DB::table('users')->insert(
            ['email' => $email, 'key' => $key]
        );
        return "Added ".$email;
    }

    /**
     * Return the login view
     * @return view
     */
    public function login(Request $request){
        $email = $request->email;
        $found = DB::table('users')->where('email', '=', $email)->count();
        if($found == 1){
            Cookie::queue('email', $request->email, 10000);
            return redirect()->intended('/dashboard');
        }else{
            return redirect()->intended('/home');
        }
    }

    /**
     * Logout the user
     */
    public function logout(){
        Cookie::queue('email', '', -10000);
        return redirect()->intended('/');
    }
}
