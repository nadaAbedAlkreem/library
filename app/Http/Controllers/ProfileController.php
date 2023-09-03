<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admins;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
     public function index()
     {
        
         $adminUser = Auth::guard('admin')->user(); 
          return response()->view('Auth.profile' ,['admin' => $adminUser] ) ; 
     }
}
