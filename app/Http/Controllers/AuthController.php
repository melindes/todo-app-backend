<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=>Hash::make($request->password)
        ]);
        $token= $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'=> 'Inscription réussie',
            'token'=>$token,
            'user' => new UserResource($user)
        ],201);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user|| !Hash::check($request->password,$user->password)){
            return response()->json([
                'message'=>'Email ou mot de passe incorrect'
            ],401);
        }
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message'=> 'Connexion réussie',
            'token'=>$token,
            'user' =>new UserResource($user)
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'Déconnexion réussie'
        ]);
    }
}
