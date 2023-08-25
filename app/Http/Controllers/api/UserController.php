<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\api\User;
use Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return $request->user();
    }


    /*public function register(Request $request){

        // $encryptedPass = Hash::make($request->password);

        $user = new User;

        try{
            $user->cooperative_id = $request->id;
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $photo = '';
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            if($request->photo!=''){

                $photo = time().'.jpg';

                file_put_contents('storage/profiles/'.$photo,base64_decode($request->photo));
                $user->photo = $photo;
            }
            $user->save();
            return $this->login($request);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }
    }*/
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
        ]);
        $result = User::create([
            'name'=>$request->name,
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
            $user = Auth::user();
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
        $request->user()->forceFill([
            'api_token'=>null,
        ])->save();
        return response()->json(['message'=>'success']);
    }
}
