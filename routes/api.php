<?php

use Illuminate\Http\Request;

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
// Without Bearer Token links 
Route::group(['middleware' => ['cors', 'json.response'], 'prefix' => '/v1', 'namespace' => 'API\v1'], function(){

    // User Login and registration routes
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    Route::post('forgot/password', 'UserController@passwordResetLink');
    Route::post('update/password', 'UserController@updateNewPassword');
      
});

// With Bearer Token links
Route::namespace('API\v1')->prefix('/v1')->middleware(['auth:api','json.response'])->group(function(){

    // User routes
    Route::get('/user/detail', 'UserController@userDetail');
    Route::post('/password/update', 'UserController@updatePassword');
    Route::post('/detail/update', 'UserController@updateDetail');

});
