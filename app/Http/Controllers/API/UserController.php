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
            //jika hash tidak sesuai maka beri error
            $user = User::where('email',$request->email)->first();
            if(!Hash::check($request->password, $user->password,[])){
                throw new \Exception('Invalid credentials');
            }
            //jika berhasil maka loginkan
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => $Bearer,
                'user' => $user,
            ],'Authenticated');
        }
        catch(Exception $error){
            return ResponseFormatter::error([
                'message'=>'Something went to wrong',
                'error'=>$error,
            ],'Authenticated failed',500);
        }
    }
}
