<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Mail ; 
use App\Mail\MailNotifyResetMassage  ; 
class MailController extends Controller
{
    public function index (Request   $request) 
    {
        $data = 
        ['body'=> " reset your password  "  ]  ; 

        try{
            Mail::to('hala.n.nofal@gmail.com')->send(new MailNotifyResetMassage($data));
            return response()->json([
                 'success access and send ' ]);
        }catch(\Exception $th)
        {
        //throw $th
        return response()->json([
            'error' => $th->getMessage()
        ]);
        }
    }
}
