<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;


class LoginController extends Controller
{
    public function register(Request $request){
        //
        try{
            $request->validate([
                'name' => ['required', 'string', 'max:20'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
        }
        catch(ValidationException $exc){
            return response()->json([
                'register_result' => 'validation error',
                'message' => $exc->getMessage()
            ]);
        }

        // User 에 등록
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 등록 성공
        if($user){
            $message = 'name : '.$user->name.'   '.'email : '.$user->email.' 님 등록 되었어요';
            return response()->json([
                'register_result' => 'success',
                'message' => $message
            ], 200);
        }
        //등록 실패
        else{
            return response()->json([
                'register_result' => 'fail',
                'message' => 'fail in register, contact to admin'
            ]);
        }

    }

    public function login(Request $request){

        // email과 password를 validation 실패시 error message 포함한 response 보냄

        try{
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255',],
                'password' => ['required', Rules\Password::defaults()],
            ]);
        }
        catch(ValidationException $exc){
            return response()->json([
                'login_result' => 'validation error',
                'message' => $exc->getMessage()
            ]);
        }

        $user = User::where('email', '=', $request->email)->first();

        // email 이 없거나 password가 틀리면 message 함깨 response
        if($user){
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'login_result' =>'login failed',
                    'message' => 'confirm your password'
                ]);
            }
        }
        else{
            return response()->json([
                'login_result' =>'login failed',
                'message' => 'confirm your email'
            ]);
        }

        // token 생성
        $access_token = $user->createToken('api-token')->plainTextToken;

        // token 생성 실패시
        if(!$access_token){
            return response()->json([
                'login_result' =>'login failed',
                'message' => 'token not created. contact admin'
            ]);
        }

        // 생성한 token과 함깨 response
        return response()->json([
            'login_result' =>'success',
            'access_token' => $access_token,
            'type' => 'bearer',
            'message' => $user->email.'님 로그인 되었습니다'
        ], 200);
    }

    public function logout(Request $request){
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'logout_result' => 'success',
            'message' => $user->email.' 님 logout 되었어요'
        ], 200);
    }

}
