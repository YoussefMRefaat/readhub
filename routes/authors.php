<?php

use Illuminate\Support\Facades\Route;

Route::group([
    // Only admins are authorized to access this group of routes
    'middleware' => ['auth:sanctum' , 'roles:admin'],
    // ID must be a number in all routes of this group
    'where' => ['id' => '[0-9]+'],
],function(){
    // Create a new author
    Route::post('' , [\App\Http\Controllers\Authors\CreateController::class , 'store']);
    // Update information of an author
    Route::patch('/{id}' , [\App\Http\Controllers\Authors\UpdateController::class , 'update']);
    // Update an image of an author
    Route::patch('/{id}/image' , [\App\Http\Controllers\Authors\UpdateController::class , 'updateImage']);
    // Delete an author
    Route::delete('/{id}' , [\App\Http\Controllers\Authors\DeleteController::class , 'destroy']);
    // Get all authors
    Route::get('' , [\App\Http\Controllers\Authors\ShowController::class , 'index']);

});

// Get a specific author and his books. ID must be a number
Route::get('/{id}' , [\App\Http\Controllers\Authors\ShowController::class , 'show'])
    ->whereNumber('id');
