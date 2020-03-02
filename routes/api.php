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

  // = belum

  Route::post('login', 'AuthApiController@login');
  Route::post('register', 'AuthApiController@register');
  Route::get('logout', 'AuthApiController@logout');
  Route::get('getAuthUser', 'AuthApiController@getAuthUser');//bisa, belum tentu dipakai
  
  Route::get('konten', 'KontenController@index');
  Route::get('konten/{id}', 'KontenController@show');
  Route::post('konten', 'KontenController@store');
  Route::put('konten/{id}', 'KontenController@update');//belum tentu dipakai, hanya admin
  Route::delete('konten/{id}', 'KontenController@destroy');//belum tentu dipakai, hanya admin

  Route::get('konten/judul/{judul}', 'KontenController@showByJudul');

  Route::get('konten/{konten}/donatur', 'DonaturController@index');
  Route::get('konten/{konten}/donatur/{id}', 'DonaturController@show');//
  Route::post('konten/{konten}/donatur', 'DonaturController@store');
  Route::put('konten/{konten}/donatur/{id}', 'DonaturController@update');
  Route::delete('konten/{konten}/donatur/{id}', 'DonaturController@destroy');

  Route::get('konten/{konten}/perkembangan', 'PerkembanganController@index');
  Route::post('konten/{konten}/perkembangan', 'PerkembanganController@store');
  Route::delete('konten/{konten}/perkembangan/{id}', 'PerkembanganController@destroy');//belum tentu dipakai

  Route::get('user/me/konten', 'UserKontenController@index');
  Route::get('user/me/konten/{id}', 'UserKontenController@show');

  Route::get('user/me/donatur', 'UserDonaturController@index');
  Route::get('user/me/konten/{konten}/donatur/{$id}', 'UserDonaturController@show');//belum bisa, belum tentu digunakan
