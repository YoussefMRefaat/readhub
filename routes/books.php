<?php

use Illuminate\Support\Facades\Route;

Route::group([
    // Only admins are authorized to access this group of routes
    'middleware' => ['auth:sanctum' , 'roles:admin'],
    // ID must be a number in all routes of this group
    'where' => ['id' => '[0-9]+'],
], function(){
    // Create a new book
    Route::post('' , [\App\Http\Controllers\Books\CreateController::class , 'store']);
    // Get all books
    Route::get('' , [\App\Http\Controllers\Books\ShowController::class , 'index']);
    // Update information of a book
    Route::patch('/{id}' , [\App\Http\Controllers\Books\UpdateController::class , 'update']);
    // Update the image of a book
    Route::patch('/{id}/images' , [\App\Http\Controllers\Books\UpdateController::class , 'updateImage']);
    // Update the authors of a book
    Route::patch('/{id}/authors' , [\App\Http\Controllers\Books\UpdateController::class , 'updateAuthors']);
    // Delete a book
    Route::delete('/{id}' , [\App\Http\Controllers\Books\DeleteController::class , 'destroy']);
});

// Get a specific book and its reviews. ID must be a number
Route::get('/{id}' , [\App\Http\Controllers\Books\ShowController::class , 'show'])
    ->whereNumber('id');
// Search for an author or a book. Search can only be characters or numbers
Route::get('/{search}' , [\App\Http\Controllers\Books\ShowController::class , 'search'])
    ->whereAlphaNumeric('search');
