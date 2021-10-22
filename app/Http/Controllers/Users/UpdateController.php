<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Traits\ImageHandler;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    use ImageHandler;

    /**
     * Update the user's information
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::find(auth()->id());
        $data = $request->validated();
        if(auth()->user()->email !== $data['email'])
            $data = array_merge($data , ['email_verified_at' => null]);
        $user->update($data);
        return response()->json([
            'Message' => 'User updated successfully',
        ], 200);
    }

    /**
     * Update the user's avatar
     *
     * @param UpdateAvatarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(UpdateAvatarRequest $request): \Illuminate\Http\JsonResponse
    {
        $path = $this->saveImage($request->validated()['avatar'] , 'avatars');
        $user = User::find(auth()->id());
        if($user->avatar){
            $this->deleteOld($user->avatar);
        }
        $user->update(['avatar' => $path]);
        return response()->json([
            'Message' => 'Avatar Uploaded successfully',
        ], 200);
    }

    /**
     * Update the user's password
     *
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $user = User::find(auth()->id());
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);
        return response()->json([
            'Message' => 'Password updated successfully',
        ], 200);
    }
}
