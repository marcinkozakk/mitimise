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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//User Actions

Route::prefix('users')->group(function () {
    Route::get('me', 'UsersController@me')->name('users.me');
    Route::get('show/{id}', 'UsersController@show')->name('users.show');
    Route::post('uploadPhoto', 'UsersController@uploadPhoto');
    Route::post('search', 'UsersController@search');
});

//Circles Actions

Route::prefix('circles')->group(function () {
    Route::post('create', 'CirclesController@create')->name('circles.create');
    Route::post('update/{id}', 'CirclesController@update')->name('circles.update');
    Route::post('delete/{id}', 'CirclesController@delete')->name('circles.delete');
    Route::get('show/{id}', 'CirclesController@show')->name('circles.show');
});

//Memberships Actions

Route::prefix('memberships')->group(function () {
    Route::post('create', 'MembershipsController@create')->name('memberships.create');
    Route::post('delete', 'MembershipsController@delete')->name('memberships.delete');
});