<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return [
            'user'=>null
        ] ;
    }
    public function login(LoginRequest $request){
        $data = $request->validated();
        if(!Auth::attempt($data)){
            return response(['errors'=>['The email or the password are incorrect']],422);
        }
        $user = Auth::user();
        return [
            'token'=>$user->createToken('token')->plainTextToken,
            'user'=>$user
        ];


    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        //Create the user:
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'isSeller'=>$data['isSeller'],
            
            'password'=>bcrypt($data['password']),
            
        ]);
        return ['token'=>$user->createToken('token')->plainTextToken,
                'user'=> $user
                
    ];
    }
    
}

