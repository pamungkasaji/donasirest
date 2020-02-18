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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
//   });
  
  Route::post('login', 'AuthApiController@login');
  Route::post('register', 'AuthApiController@register');
  
  Route::get('konten', 'KontenController@index');
  Route::get('konten/{id}', 'KontenController@show');
  
//   Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('userinfo', 'ApiController@getAuthUser');
  
    Route::post('konten', 'KontenController@store');
    Route::put('konten/{id}', 'KontenController@update');
    Route::delete('konten/{id}', 'KontenController@destroy');
  
//   });