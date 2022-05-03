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
Route::post('registration', ['as' => 'registration', 'uses' => '\App\Http\Controllers\API\AuthAPIController@registration']);

Route::post('login', ['as' => 'login', 'uses' => '\App\Http\Controllers\API\AuthAPIController@login']);

Route::get('user', ['as' => 'getUser', 'uses' => '\App\Http\Controllers\API\UserAPIController@getUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::patch('user/update', ['as' => 'update', 'uses' => '\App\Http\Controllers\API\UserAPIController@update']);

    Route::post('logout', ['as' => 'logout', 'uses' => '\App\Http\Controllers\API\AuthAPIController@logout']);

    Route::resource('articles', App\Http\Controllers\API\ArticleAPIController::class);
});







