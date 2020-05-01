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

Route::get('konten', 'KontenController@index');
Route::post('konten', 'KontenController@store');
Route::get('konten/judul/{judul}', 'KontenController@showByJudul');
Route::get('user/me/konten', 'KontenController@indexUser');
Route::get('user/me/konten/{id}', 'KontenController@isUser');

Route::post('login', 'AuthApiController@login');
Route::post('register', 'AuthApiController@register');
Route::get('logout', 'AuthApiController@logout');

Route::get('konten/{konten}/donatur', 'DonaturController@index');
Route::post('konten/{konten}/donatur', 'DonaturController@store');
Route::get('user/me/donatur', 'DonaturController@indexUser');
Route::put('konten/{konten}/donatur/{id}/approve', 'DonaturController@approve');
Route::delete('konten/{konten}/donatur/{id}/disapprove', 'DonaturController@disapprove');

Route::get('konten/{konten}/perkembangan', 'PerkembanganController@index');
Route::post('konten/{konten}/perkembangan', 'PerkembanganController@store');

Route::post('konten/{konten}/perpanjangan', 'PerpanjanganController@store');
