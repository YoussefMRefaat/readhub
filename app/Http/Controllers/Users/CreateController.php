<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignupRequest;
use App\Models\User;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateController extends Controller
{
    use ImageHandler;

    /**
     * Store a new user in DB and
     *
     * @param SignupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SignupRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $data = array_merge($validated , ['role' => 'user' , 'password' => Hash::make($validated['password'])]);

        if(isset($validated['avatar'])){
            $path = $this->saveImage($validated['avatar'] , 'avatars');
            $data = array_merge($data , ['avatar' => $path]);
        }

        $user = User::create($data);
        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'Message' => 'User registered successfully',
            'Token' => $token,
        ] , 201);
    }
}
