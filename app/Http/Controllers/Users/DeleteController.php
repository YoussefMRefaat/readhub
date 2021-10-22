<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    use ImageHandler;

    /**
     * Delete a user - for admins -
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        if($user->avatar)
            $this->deleteOld($user->avatar);
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'Message' => 'User removed successfully',
        ], 200);
    }

    /**
     * Delete the current user's account
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMe(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if($user->avatar)
            $this->deleteOld($user->avatar);
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'Message' => 'User removed successfully'
        ], 200);
    }
}
