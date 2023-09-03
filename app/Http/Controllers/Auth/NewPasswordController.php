<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest ; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\PasswordReset ;  
use App\Models\Admins ; 


class NewPasswordController extends Controller
{
     public function show(Request $request , $token)
     { 
      return view('Auth.new-password') ; 
     }

     public function newPassowrdAction(Request $request)
     {         
               $emailUser = PasswordReset::
                where('token' , $request['token'])
               ->where('active'  ,  1 )->first();
          if($emailUser)
          {
               $AdminUser =Admins::where('email' , $emailUser['email'])->first(); 
               $AdminUser->password = Hash::make( $request['password']) ; 
                   if($AdminUser->update())
                   {
                        $emailUser->active = 0  ; 
                        $emailUser->update() ; 
                        return response()->json([
                             'success' => ' password updated  successfully!'
                        ]);
                   }
                   else 
                   {
                        return response()->json([
                             'error' => 'There is a connection error unable to update'
                        ]);
                   }
          }else
          {
               return response()->json([
                    'error' => 'Invalid token'
               ]);
          }
         
        
     }
   
}
 
