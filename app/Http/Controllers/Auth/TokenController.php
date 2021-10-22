<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Http\Request;

class TokenController extends Controller
{

    /**
     * Login the user by providing a token
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        if(!auth()->attempt($request->validated()))
            abort(401 , 'Invalid email or password');
        $token = auth()->user()->createToken('auth')->plainTextToken;
        return response()->json([
            'Message' => 'Logged in successfully',
            'Token' => $token,
            'Role' => auth()->user()->role,
        ], 201);
    }


    /**
     * Logout the user by deleting the token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'Message' => 'Logged out successfully',
        ], 200);
    }
}
