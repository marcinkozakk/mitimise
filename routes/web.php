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

//Meetings Actions

Route::prefix('meetings')->group(function () {
    Route::get('show/{id}', 'MeetingsController@show')->name('meetings.show');
    Route::post('create', 'MeetingsController@create')->name('meetings.create');
    Route::post('update/{id}', 'MeetingsController@update')->name('meetings.update');
    Route::post('setDate/{id}', 'MeetingsController@setDate')->name('meetings.setDate');
    Route::get('cancel/{id}', 'MeetingsController@cancel')->name('meetings.cancel');
    Route::post('revertCancelation/{id}', 'MeetingsController@revertCancelation')->name('meetings.revert');
});

//Invitations Actions

Route::prefix('invitations')->group(function () {
    Route::post('invite', 'InvitationsController@invite')->name('invitations.invite');
    Route::get('delete/{user_id}/{meeting_id}', 'InvitationsController@delete')->name('invitations.delete');
    Route::get('setState/{meeting_id}/{state}', 'InvitationsController@setState')->name('invitations.setState');
});

//Comments Actions

Route::prefix('comments')->group(function() {
    Route::post('create/{meeting_id}', 'CommentsController@create')->name('comments.create');
    Route::post('delete', 'CommentsController@delete')->name('comments.delete');
});

//Date Polls Actions

Route::prefix('datePolls')->group(function() {
    Route::post('setAvailability/{meeting_id}', 'DatePollsController@setAvailability')->name('datePolls.setAvailability');
    Route::post('delete', 'DatePollsController@delete')->name('datePolls.delete');
});