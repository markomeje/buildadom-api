<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    /**
     * Login
     * @param $request
     */
    public function login(LoginRequest $request)
    {
        $token = auth()->attempt($request);
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 401);
        }

        $user = auth()->user();
        return response()->json([
            'success' => true,
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
            'message' => 'Login successful',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Refresh user token
     */
    public function refresh()
    {
        return response()->json([
            'success' => true,
            'user' => auth()->user(),
            'authorisation' => [
                'token' => auth()->refresh(),
                'type' => 'bearer',
            ],
            'message' => 'Token refreshed',
        ]);
    }
}


