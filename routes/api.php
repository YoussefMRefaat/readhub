<?php

use Illuminate\Support\Facades\Route;

// Get the data of the homepage
Route::get('/home' , [\App\Http\Controllers\Books\ShowController::class , 'home']);
