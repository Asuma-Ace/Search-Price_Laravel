<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\loginRequest;

class LoginController extends Controller
{
    /**
     * ログイン画面を表示
     * 
     * @return view
     */
    public function login()
    {
        return view('user.login');
    }

    /**
     * ログイン完了画面を表示
     * 
     * @return view
     */
    public function userComplete()
    {
        if(Auth::check()) {
            return view('user.complete');
        } else {
            return view('user.login');
        }
    }

    /**
     * ログアウト画面を表示
     * 
     * @return view
     */
    public function userLogout()
    {
        if(!Auth::check()) {
            return view('user.logout');
        } else {
            return redirect()->action('Auth\LoginController@logout');
        }
    }

}
