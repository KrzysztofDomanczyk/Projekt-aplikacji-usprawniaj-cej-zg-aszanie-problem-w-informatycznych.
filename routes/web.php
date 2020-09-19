<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function () {
    Route::resource('projects', 'ProjectController');
    Route::get('/roles', 'PermissionController@Permission')->name('roles');
    Route::get('/unseen-message', 'TicketController@getUnSeenMail')->name('getUnSeenMail');
    Route::get('/user-settings', 'PageController@userSettings')->name('userSettings');
    Route::get('/create-ticket/{id}', 'TicketController@create')->name('createTicket');
    Route::get('/mail-body/{id}', 'TicketController@mailBody')->name('mailBody');

    Route::prefix('user-settings')->group(function () {
        Route::get('/', 'UserController@userSettings')->name('userSettings');
        Route::post('change-imap', 'UserController@changeImap')->name('changeImap');
    });

    Route::resource('ticket', 'TicketController');

});

