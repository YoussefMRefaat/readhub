<?php

use Illuminate\Support\Facades\Route;
// Set id pattern to be a number for all routes in this file
Route::pattern('id' , '[0-9]+');

Route::group([
    // Only normal users, not admins, are authorized to access this group of routes
    'middleware' => ['auth:sanctum' , 'roles:user'],
] , function(){
    // Create a new review
    Route::post('' , [\App\Http\Controllers\Reviews\CreateController::class , 'store']);
    // Update the rating of a review
    Route::patch('/{id}/rating' , [\App\Http\Controllers\Reviews\UpdateController::class , 'updateRating']);
    // Update the comment of a review
    Route::patch('/{id}/comment' , [\App\Http\Controllers\Reviews\UpdateController::class , 'updateComment']);
    // Like a review or undo a like
    Route::post('/{id}/like' , [\App\Http\Controllers\Reviews\LikeController::class , 'like']);
    // Dislike a review or undo a dislike
    Route::post('/{id}/dislike' , [\App\Http\Controllers\Reviews\LikeController::class , 'dislike']);
});
// Delete a review. Admins and users can access this route
Route::delete('/{id}' , [\App\Http\Controllers\Reviews\DeleteController::class , 'destroy'])
    ->middleware(['auth:sanctum' , 'roles:admin,user']);
// Get a specific review and the updating history
Route::get('/{id}' , [\App\Http\Controllers\Reviews\ShowController::class , 'show']);
// Get likes or dislikes of a review. Path only can be 'likes' or 'dislikes'
Route::get('/{id}/{path}' , [\App\Http\Controllers\Reviews\ShowController::class , 'showLikes'])
    ->where('path' , 'likes|dislikes');
