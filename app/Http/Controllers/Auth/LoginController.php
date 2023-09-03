<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Requests\LoginRequest ; 
use Illuminate\Support\Facades\Auth;
 
class LoginController extends Controller
{
   
  public function showLogin()
  {
   
    return response()->view('Auth.login') ; 
  }

  public function Login(LoginRequest $request)
  {
      $loggedIn = Auth::guard('admin')->attempt($request->loginInfo()) ; 
  
    if($loggedIn)
    {
      return response()->json(['message' =>  "success"  , 'status' => true]);

      }
    else 
    {       
      return response()->json(['message' =>  "password and email not correct "   , 'status' => false ]);
    }
  }
  public function logout(Request $request)
  {
    Auth::guard('admin')->logout(); 
    $request->session()->invalidate() ; 
    return redirect('/'); 


  }
}
