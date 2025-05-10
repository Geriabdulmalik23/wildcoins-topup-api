<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper as R;
use App\Services\AuthService;

class AuthController extends Controller
{

    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'name'      => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return R::validationError($validator);
        }

        $data = app(AuthService::class)->register($request->only(['email', 'password', 'name']));
        return R::success($data, 'Registrasi berhasil');

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return R::validationError($validator);
        }

        $data = app(AuthService::class)->login($credentials);

        if ($data == null) {
            return R::error('Email atau password salah', 401);
        }

        return R::success($data, 'Login berhasil');
    }

    public function me()
    {
        $user = app(AuthService::class)->me();
        return R::success($user,'Data tersedia',200);
    }

    public function logout()
    {
        $user = app(AuthService::class)->logout();
        return R::success($user,message:'Berhasil logout');
    }
}
