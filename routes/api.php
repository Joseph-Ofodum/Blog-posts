<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::resource('permissions', App\Http\Controllers\PermissionController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

Route::get('/test', function (){
    return 'This is a test';
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Route::post('/logout', [AuthController::class, 'logout']);
Route::resource('/blogs', BlogsController::class);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/blogs', BlogsController::class);
});