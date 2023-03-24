<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('frontend.login');
    }

    public function post_login(Request $request){

        $request->validate([
            'name' => 'required|string',
            'password'=> 'required|string'
        ]);

        $credentials = ['name'=>$request->get('name') , 'password' =>$request->get('password')];

        if(Auth::attempt($credentials)){
            $posts = Post::all();
            return view('frontend.home' , compact('posts'));
        }

    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()->route('user.login');
    }
}
