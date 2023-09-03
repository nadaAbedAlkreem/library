<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest ; 
use App\Models\Admins ; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function show()
    {
        return response()->view('Auth.register') ; 
    }
    public function register(Request $request)
    {  
  
        $validator = Validator::make($request->all(), 
        [    
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|unique:Admins|max:255',
            'password' => 'required|string|min:8',
        ]);
 
         if ($validator->fails()) 
            {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422); 
            }
            $fullName = $request['firstName'].' '.$request['lastName']; 
            $register =  Admins::create(
                [
                    'name' => $fullName,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
               ]);

            if ($register){   
                return response()->view('Auth.login') ; 
    
                // return response()->json([
                // 'success' => "success" ])  ;  
             }

    }
}
