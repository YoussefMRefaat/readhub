<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * Redirect the user to the Oauth provider
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Receive user's information from the provider
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(): \Illuminate\Http\JsonResponse
    {
        $socialUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email' , $socialUser->email)->first();
        if($user){
            $token = $user->createToken('auth')->plainTextToken;
            $message = 'Logged in successfully';
        }else{
            $token = $this->createUser($socialUser->getName() , $socialUser->getEmail());
            $message = 'User registered successfully';
        }
        return response()->json([
            'Message' => $message,
            'Token' => $token,
        ], 201);
    }

    /**
     * Create a new user
     *
     * @param string $name
     * @param string $email
     * @return string
     */
    private function createUser(string $name, string $email): string
    {
        $user = User::create([
            'name' => $name,
            'role' => 'user',
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make(null),
        ]);
        return $user->createToken('auth')->plainTextToken;
    }
}
