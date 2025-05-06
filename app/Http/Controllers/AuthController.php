<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use laravel\Sanctum\HasApiTokens;
class AuthController extends Controller
{
    public function register (Request $request){
        $validate = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($validate);

        $token= $user->createToken($request->name);

        return [
            'user'=> $user,
            'token' => $token->plainTextToken
        ];
    }
    public function login (Request $request){
        $request->validate([
            'email'=>'required|email|exists:users',
            'password'=> 'required'
        ]);
        $user = User::where('email',$request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            return[
                    'error' => ['email'=> ['The provided credentials are incorrect.']]
            ];
        }
        $token = $user->createToken($user->name);

        return [
            'user'=>$user,
            'token'=>$token->plainTextToken 
        ];
    }

    public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logout berhasil'
    ]);
}

}
