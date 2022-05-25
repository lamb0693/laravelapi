<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


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

}
