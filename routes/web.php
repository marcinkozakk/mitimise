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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

//User Actions

Route::prefix('users')->group(function () {
    Route::get('me', 'UsersController@me')->name('users.me');
    Route::get('show/{id}', 'UsersController@show')->name('users.show');
    Route::post('uploadPhoto', 'UsersController@uploadPhoto');
    Route::post('search', 'UsersController@search');
});
