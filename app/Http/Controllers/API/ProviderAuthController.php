<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Utils\ResponseHandler;
use App\Models\Auth\UserModel;

class ProviderAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $user = UserModel::where('username', hash('sha256', $request->username))->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseHandler::error('Credenciales inválidas', 401);
        }

        $token = JWTAuth::fromUser($user);

        return ResponseHandler::success(['token' => $token]);
    }
}
