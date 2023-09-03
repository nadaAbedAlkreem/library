<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admins ;  
use App\Models\PasswordReset ;  
use Mail ; 
use App\Mail\MailNotifyResetMassage  ; 
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str ; 
class ResetPasswordController extends Controller
{
    public function show()
    {
      return view('Auth.reset-password') ; 
    }
    public function resetPassowrdAction(Request $request)
    {
       $AdminUser =  Admins::where('email', $request['email'])->first();
       $token = Str_random(60) ;

       if($AdminUser)
       {
            $data =['title'=>"reset your password" ,
                    'body'=> "Hello my friend, there are attempts to change your password. If you want to change it, click on the following button"
                    ,'token' => $token ]  ; 
                try
                {
                    Mail::to($request['email'])->send(new MailNotifyResetMassage($data));
                    PasswordReset::create([
                        'email' => $request->email,  
                        'active'=> 1 , 
                        'token' => $token  , 
                      
                    
                    ]);
                    return response()->json(['message'=>'success send' , 'icon'=>'success'   ]);
                }
                catch(\Exception $th)
                {
                     return response()->json(['message' => $th->getMessage() , 'icon' =>'error']);
                }
        }else
        {
            return response()->json(['message' => 'This email does not exist' ,  'icon' =>'error']);
        
       }
}
}
