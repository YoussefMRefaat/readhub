<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    /**
     * Show all users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = User::where('role' , 'user')->get();
        return response()->json([
            'Message' => 'Users retrieved successfully',
            'Data' => $users,
        ], 200);
    }


    /**
     * Get the user's information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showMe(): \Illuminate\Http\JsonResponse
    {
        $user = User::select('name' , 'email' , 'avatar')->find(auth()->id());

        return response()->json([
            'Message' => 'User retrieved successfully',
            'Data' => $user,
        ], 200);
    }
}
