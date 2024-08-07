<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        return $request->has('email') ? $this->loginUser($request) : $this->loginEmpresa($request);
    }

    public function loginEmpresa($request)
    {
        $empresa = Empresa::where('cnpj', $request->cnpj)->first();

        if (!$empresa || !Hash::check($request->password, $empresa->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $empresa->createToken($empresa->razaoSocial . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function loginUser($request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            "message" => "logged out"
        ]);
    }
}
