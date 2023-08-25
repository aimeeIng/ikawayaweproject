<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\Reporter;
use Auth;


class ReportersController extends Controller
{
    public function index(Request $request)
    {
        return $request->reporter();
    }

    public function register(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
        ]);
        $result = Reporter::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        return $result;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if(Auth::attempt($credentials) ){
            $reporter = Auth::reporter();
            $token = md5( time() ).'.'.md5($request->email);
            $user->forceFill([
                'api_token'=>$token,
            ])->save();
            return response()->json([
                'token'=>$token
            ]);
        }

        return response()->json([
            'message'=>'The provided credentials do not match our records'
        ],401);
    }

    public function logout(Request $request)
    {
        $request->reporter()->forceFill([
            'api_token'=>null,
        ])->save();
        return response()->json(['message'=>'success']);
    }
}
