<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        $user = new User();
        $user -> name = $request->name;
        $user -> email = $request->email;
        $user -> password = Hash::make($request->password);
        $user -> email_verified_at = Carbon::now();
        $user->save();

        return response()->json([
            'status' => 1,
            'messagge' => "Usario creado con exito!"
        ]);   
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where("email", "=", $request->email)->first();
        
        if(isset($user->id)){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    'status' => 1,
                    'messagge' => "Usuario logueado con exito",
                    "acces_token" => $token
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'messagge' => "La contraseña es incorrecta"
                ]);
            }
        }else{
            return response()->json([
                'status' => 0,
                'messagge' => "Usuario no registrado"
            ],404);
        } 
    }

    public function userProfile()
    {
        return response()->json([
            'status' => 0,
            'messagge' => "Datos del perfil del usuario",
            'data' => auth()->user()
        ]);      
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 0,
            'messagge' => "Cierre de sesión con éxito!"
        ]);          
    }
}
