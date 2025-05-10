<?php

namespace App\Services;

use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Contracts\Auth\Guard;


class AuthService{

    public function register(array $data){

        $user = User::create([
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'name'      => $data['name'],
        ]);

        $token = JWTAuth::fromUser($user);

        return compact('user','token');
    }

    public function login(array $credentials){

        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }

        $user = JWTAuth::user();

        return compact('user', 'token');

    }

    public function me()
    {
        return Auth::user();
    }

    public function logout(){
        return Auth::logout();
    }
}