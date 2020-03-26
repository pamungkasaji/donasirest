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

Route::namespace('Admin')->middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/konten', 'AdminKontenController', ['except' => ['create', 'store']]);
    Route::resource('/user', 'AdminUserController', ['except' => ['create', 'store']]);

    Route::get('/verifikasi', 'VerifikasiController@index')->name('verifikasi.index');

    Route::get('/verifikasi/konten/{id}', 'VerifikasiController@showKonten')->name('verifikasi.konten.show');
    Route::put('/verifikasi/konten/approve/{id}', 'VerifikasiController@approveKonten')->name('verifikasi.konten.approve');
    Route::put('/verifikasi/konten/disapprove/{id}', 'VerifikasiController@disapproveKonten')->name('verifikasi.konten.disapprove');

    Route::get('/verifikasi/perpanjangan/{id}', 'VerifikasiController@showPerpanjangan')->name('verifikasi.perpanjangan.show');
    Route::put('/verifikasi/perpanjangan/approve/{id}', 'VerifikasiController@approvePerpanjangan')->name('verifikasi.perpanjangan.approve');
    Route::put('/verifikasi/perpanjangan/disapprove/{id}', 'VerifikasiController@disapprovePerpanjangan')->name('verifikasi.perpanjangan.disapprove');

    //Route::get('/verifikasi/user', 'VerifikasiUserController@index')->name('verifikasi.user.index');
    Route::get('/verifikasi/user/{id}', 'VerifikasiController@showUser')->name('verifikasi.user.show');
    Route::put('/verifikasi/user/approve/{id}', 'VerifikasiController@approveUser')->name('verifikasi.user.approve');
    Route::delete('/verifikasi/user/disapprove/{id}', 'VerifikasiController@disapproveUser')->name('verifikasi.user.disapprove');
});
