<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function showlogin(){
    return view('admin.auth.login');
   }
   public function login(LoginRequest $request){
    if(auth()->guard('admin')->attempt(['username'=>$request->input('username'),'password'=>$request->input('password')])){
        return redirect()->route('admin.dashboard');


    }else{
        return redirect()->route('admin.showlogin');
    }

   }
   public function logout(){
    auth()->logout();
    return redirect()->route('admin.login');
   }
   public function make_new_admin(){
    $admin = new Admin();
    $admin->name = 'Amjad';
    $admin->email = 'Admin@gmail.com';
    $admin->username = 'admin';
    $admin->password = bcrypt("admin");
    $admin->com_code = 1 ;
    $admin->save();
   }
}
