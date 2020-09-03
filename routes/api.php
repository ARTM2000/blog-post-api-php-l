<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/* User-interaction routes */
Route::group(["prefix" => "v1"], function() {
    
    //creating new user
    Route::post('create-user', 'UserController@createUser');
    //verify new user
    Route::post('login', "UserController@verifyUser");

    // Get user's posts
    Route::post('user-post', 'UserController@getUserPost');
});

/* Post-interaction routes */
Route::group(["prefix" => "v1"], function () {
    Route::post('create-post', 'PostController@createPost');
});