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
//Route::get('/admin/verifikasi','Admin\HomeController@index')->middleware('auth')->name('home');

Route::namespace('Admin')->middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    //Route::get('/dashboard','HomeController@index')->name('dashboard');

    Route::get('/verifikasi','HomeController@index')->middleware('auth')->name('home');

    Route::get('/konten', 'AdminKontenController@index')->name('konten.index');
    Route::get('/konten/{id}', 'AdminKontenController@show')->name('konten.show');
    Route::put('/konten/{id}/nonaktif', 'AdminKontenController@nonaktif')->name('konten.nonaktif');
    Route::delete('/konten/{id}/delete', 'AdminKontenController@delete')->name('konten.delete');
    Route::get('/konten/{id}/print', 'AdminKontenController@print')->name('konten.print');

    Route::get('/user', 'AdminUserController@index')->name('user.index');
    Route::get('/user/{id}', 'AdminUserController@show')->name('user.show');
    Route::delete('/user/{id}', 'AdminUserController@delete')->name('user.delete');

    //Route::get('/verifikasi', 'VerifikasiController@index')->name('verifikasi.index');

    Route::get('/verifikasi', function () {
        return view('admin.verifikasi.verif');
    })->name('verifikasi');

    Route::get('/verifikasi/konten', 'VerifikasiController@indexKonten')->name('verifikasi.konten.index');
    Route::get('/verifikasi/konten/{id}', 'VerifikasiController@showKonten')->name('verifikasi.konten.show');
    Route::put('/verifikasi/konten/{id}/approve', 'VerifikasiController@approveKonten')->name('verifikasi.konten.approve');
    Route::put('/verifikasi/konten/{id}/disapprove', 'VerifikasiController@disapproveKonten')->name('verifikasi.konten.disapprove');
    Route::delete('/verifikasi/konten/{id}', 'VerifikasiController@deleteKonten')->name('verifikasi.konten.delete');

    Route::get('/verifikasi/perpanjangan', 'VerifikasiController@indexPerpanjangan')->name('verifikasi.perpanjangan.index');
    Route::get('/verifikasi/perpanjangan/{id}', 'VerifikasiController@showPerpanjangan')->name('verifikasi.perpanjangan.show');
    Route::put('/verifikasi/perpanjangan/{id}/approve', 'VerifikasiController@approvePerpanjangan')->name('verifikasi.perpanjangan.approve');
    Route::put('/verifikasi/perpanjangan/{id}/disapprove', 'VerifikasiController@disapprovePerpanjangan')->name('verifikasi.perpanjangan.disapprove');
    Route::delete('/verifikasi/perpanjangan/{id}', 'VerifikasiController@deletePerpanjangan')->name('verifikasi.perpanjangan.delete');

    Route::get('/verifikasi/user', 'VerifikasiController@indexUser')->name('verifikasi.user.index');
    Route::get('/verifikasi/user/{id}', 'VerifikasiController@showUser')->name('verifikasi.user.show');
    Route::put('/verifikasi/user/{id}/approve', 'VerifikasiController@approveUser')->name('verifikasi.user.approve');
    Route::put('/verifikasi/user/{id}/disapprove', 'VerifikasiController@disapproveUser')->name('verifikasi.user.disapprove');
    Route::delete('/verifikasi/user/{id}', 'VerifikasiController@deleteUser')->name('verifikasi.user.delete');

});
