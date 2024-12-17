<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //
    public function login() {
        if(Auth::check()) {
            return redirect('products');
        } else {
            return view("login");
        }
    }

    public function actionlogin(Request $request) {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if(Auth::attempt($data)) {
            return redirect('/');
        } else {
            // $request->session()
            Session::flash('error', 'Email / password wrong');
            // return view('login');
            return redirect('/');
        }
    }

    public function actionlogout() {
        Auth::logout();
        return redirect('/');
    }
}
