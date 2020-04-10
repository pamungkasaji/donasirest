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

Route::middleware('auth.jwt')->get('users', function () {
  return auth('api')->user();
});

  // = belum tentu dipakai
  Route::get('konten', 'KontenController@index');
  Route::get('konten/{id}', 'KontenController@show');//
  Route::post('konten', 'KontenController@store');
  Route::put('konten/{id}', 'KontenController@update');//
  Route::delete('konten/{id}', 'KontenController@destroy');//

  Route::post('login', 'AuthApiController@login');
  Route::post('register', 'AuthApiController@register');
  Route::get('logout', 'AuthApiController@logout');
  Route::get('getAuthUser', 'AuthApiController@getAuthUser');//bisa, belum tentu dipakai

  Route::get('konten/judul/{judul}', 'KontenController@showByJudul');
  
  Route::get('user/me/konten', 'KontenController@indexUser');
  Route::get('user/me/konten/{id}', 'KontenController@showUser');

  Route::get('konten/{konten}/donatur', 'DonaturController@index');
  Route::get('konten/{konten}/donatur/{id}', 'DonaturController@show');//tidak perlu sepertinya
  Route::post('konten/{konten}/donatur', 'DonaturController@store');
  Route::put('konten/{konten}/donatur/{id}/approve', 'DonaturController@approve');
  Route::delete('konten/{konten}/donatur/{id}/disapprove', 'DonaturController@disapprove');

  Route::get('user/me/donatur', 'DonaturController@indexUser');
  Route::get('user/me/konten/{konten}/donatur/{$id}', 'DonaturController@showUser');//belum bisa, belum tentu digunakan

  Route::get('konten/{konten}/perkembangan', 'PerkembanganController@index');
  Route::post('konten/{konten}/perkembangan', 'PerkembanganController@store');
  Route::delete('konten/{konten}/perkembangan/{id}', 'PerkembanganController@destroy');//belum tentu dipakai

  Route::get('perpanjangan/{id}', 'PerpanjanganController@show');//admin
  Route::post('konten/{konten}/perpanjangan', 'PerpanjanganController@store');
  //Route::put('konten/{konten}/donatur/{id}', 'DonaturController@update');//admin


