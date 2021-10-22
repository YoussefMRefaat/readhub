<?php

use Illuminate\Support\Facades\Route;

Route::group([
    // Only unauthenticated users are authorized to access this group of routes
    'middleware' => 'guest',
] , function(){
    // Signup - creates a new user
    Route::post('' , [\App\Http\Controllers\Users\CreateController::class , 'store']);
    // Login a user by his email and password
    Route::post('/tokens/' , [\App\Http\Controllers\Auth\TokenController::class , 'login']);
    // Redirect the user to the Oauth provider
    Route::get('/r' , [\App\Http\Controllers\Auth\SocialController::class , 'redirect']);
    // Login or signup a user by his social account.
    Route::get('/c' , [\App\Http\Controllers\Auth\SocialController::class , 'authenticate']);
});

Route::group([
    // Only authenticated users are authorized to access this group of routes
    'middleware' => 'auth:sanctum',
], function(){
    // Logout a user
    Route::delete('/tokens/' , [\App\Http\Controllers\Auth\TokenController::class , 'logout']);
    // Get the information of the authenticated user
    Route::get('/me/' , [\App\Http\Controllers\Users\ShowController::class , 'showMe']);
    // Update the information of the authenticated user
    Route::patch('/me/' , [\App\Http\Controllers\Users\UpdateController::class , 'update']);
    // Update the avatar of the authenticated user
    Route::patch('/me/avatars' , [\App\Http\Controllers\Users\UpdateController::class , 'updateAvatar']);
    // Update the password of the authenticated user
    Route::patch('/me/password' , [\App\Http\Controllers\Users\UpdateController::class , 'updatePassword']);
    // Delete the authenticated user
    Route::delete('/me' , [\App\Http\Controllers\Users\DeleteController::class , 'destroyMe'])
        ->whereNumber('id');
});

Route::group([
    // Only admins are authorized to access this group of routes
    'middleware' => ['auth:sanctum' , 'roles:admin'],

] , function(){
    // Get all users
    Route::get('' , [\App\Http\Controllers\Users\ShowController::class , 'index']);
    // Delete a specific users. ID must be a number
    Route::delete('/{id}' , [\App\Http\Controllers\Users\DeleteController::class , 'destroy'])
        ->whereNumber('id');
});
