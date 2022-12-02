<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function login(Request $request){
        try{
            //validasi input login 
            $request->validate([
                'email' =>'email|required',
                'password' =>'password|required'
            ]);
            //mengecek credential login
            $credentials = request(['email','password']);
            if(!Auth::attempt($credentials)){
                return ResponseFormatter::error([
                    'message' => 'unauthorized'
                ],'Authenticated Failed', 500);
            }
        }
    }
}
