<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Actions\Fortify\PasswordValidationRules;

class UserController extends Controller
{
    use PasswordValidationRules;

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

    public function register(Request $request){
        try{
            //validasi input login 
            $request->validate([
                'name' =>['required','string','max:255'],
                'email' =>['required','string','email','max:255','unique:users'],
                'password' =>$this->passwordRules(),
            ]);
         
            User::create([
                'name' =>$request->name,
                'email' =>$request->email,
                'address' =>$request->address,
                'houseNumber' =>$request->houseNumber,
                'phoneNumber' =>$request->phoneNumber,
                'city' =>$request->city,
                'password' =>Hash::make($request->password),
            ]);
            //setelah create simpan nih
            $user = User::where('email',$request->email)->first();
                    //jika berhasil maka loginkan (ambil token)
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            //kembalikan token akses,tipe dan user nya 
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => $Bearer,
                'user' => $user,
            ]);
        }
        catch(Exception $error){
            return ResponseFormatter::error([
                'message'=>'Something went to wrong',
                'error'=>$error,
            ],'Authenticated failed',500);
        }
    }
}
