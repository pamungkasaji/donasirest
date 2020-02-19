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

  Route::get('konten/{konten}/donatur', 'DonaturController@index');
  Route::get('konten/{konten}/donatur/{id}', 'DonaturController@show');
  Route::post('konten/{konten}/donatur', 'DonaturController@store');

  Route::get('konten/{konten}/perkembangan', 'PerkembanganController@index');
  
//   Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('userinfo', 'ApiController@getAuthUser');
  
    Route::post('konten', 'KontenController@store');
    Route::put('konten/{id}', 'KontenController@update');
    Route::delete('konten/{id}', 'KontenController@destroy');

    Route::put('konten/{konten}/donatur/{id}', 'DonaturController@update');
    Route::delete('konten/{konten}/donatur/{id}', 'DonaturController@destroy');

    Route::post('konten/{konten}/perkembangan', 'PerkembanganController@store');

    //belum tentu dipakai
    Route::delete('konten/{konten}/perkembangan/{id}', 'PerkembanganController@destroy');
  
//   });