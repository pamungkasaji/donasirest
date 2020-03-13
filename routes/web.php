<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::post('/login/admin', 'Auth\LoginController@adminLogin');

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){
    Route::resource('/konten', 'AdminKontenController', ['except' => ['create', 'store']]);
    Route::resource('/user', 'AdminUserController', ['except' => ['create', 'store']]);

    Route::get('/verifikasi', 'AdminVerifikasiController@index')->name('verifikasi.index');
    Route::get('/verifikasi/konten/{id}', 'AdminVerifikasiController@showKonten')->name('verifikasi.konten.show');
    // Route::put('/verifikasi/konten/approve/{id}', 'AdminVerifikasiController@approve')->name('verifikasi.konten.approve');
    // Route::put('/verifikasi/konten/disapprove/{id}', 'AdminVerifikasiController@disapprove')->name('verifikasi.konten.disapprove');

    Route::get('/verifikasi/perpanjangan/{id}', 'AdminVerifikasiController@showPerpanjangan')->name('verifikasi.perpanjangan.show');

    // Route::get('/verifikasi/user', 'AdminVerifikasiUserController@index')->name('verifikasi.index');
    // Route::get('/verifikasi/user/{id}', 'AdminVerifikasiUserController@show')->name('verifikasi.show');
    // Route::put('/verifikasi/user/approve/{id}', 'AdminVerifikasiUserController@approve')->name('verifikasi.approve');
    // Route::put('/verifikasi/user/disapprove/{id}', 'AdminVerifikasiUserController@disapprove')->name('verifikasi.disapprove');

    Route::get('/verifikasi/user', 'AdminVerifikasiUserController@showPerpanjangan')->name('verifikasi.user.index');

});
