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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("users","App\Http\Controllers\APIController@getUsers");
Route::get("user/{id}","App\Http\Controllers\APIController@getByUserId");

Route::namespace('App\Http\Controllers\API')->group(function (){
    Route::post('register-user','APIController@registerUser');
});
