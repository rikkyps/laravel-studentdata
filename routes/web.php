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


// Route::get('halaman-rahasia', 'CodehaterController@index')->name('codehater');
// Route::get('codehater', 'CodehaterController@secret');

Route::group(['middleware' => ['web']], function() {

    Route::get('/', 'PagesController@homepage');
    Route::get('about', 'PagesController@about');

    // Auth::routes();
    // Route::get('home', 'HomeController@index');

    $this->get('login', 'Auth\LoginController@showLoginForm');
    $this->post('login', 'Auth\LoginController@login');
    $this->get('logout', 'Auth\LoginController@logout', function(){
        return redirect('login');
    });

    Route::get('register', function(){
        return redirect('/');
    });

    Route::resource('user', 'UserController');

    Route::get('siswa/cari', 'SiswaController@cari');
    Route::resource('siswa', 'SiswaController');
    Route::resource('kelas', 'KelasController');
    Route::resource('hobi', 'HobiController');
    // Route::get('siswa', 'SiswaController@index');
    // Route::post('siswa', 'SiswaController@store');
    // Route::get('siswa/create', 'SiswaController@create');
    // Route::get('siswa/{siswa}', 'SiswaController@show');
    // Route::get('siswa/{siswa}/edit', 'SiswaController@edit');
    // Route::patch('siswa/{siswa}', 'SiswaController@update');
    // Route::delete('siswa/{siswa}', 'SiswaController@destroy');
    // Route::get('tes-collection', 'SiswaController@tesCollection');
    // Route::get('date-mutator', 'SiswaController@dateMutator');
});
















