<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json(Auth::id());
});


Route::middleware('auth:api')->get('/users', function (Request $request) {

    return response()->json(['name' => Auth::User()->name]);

});

Route::middleware('auth:api')->post('/project/add-user', 'ProjectController@addUserToProject')->name('addUserToProject');
Route::middleware('auth:api')->post('/project/delete-user', 'ProjectController@deleteUserToProject')->name('deleteUserToProject');
Route::middleware('auth:api')->get('/project/users-list/{id}', 'ProjectController@userList')->name('userList');
Route::middleware('auth:api')->get('/dashboard-emails', 'HomeController@getUnseenMessages')->name('getUnseenMessages');
Route::middleware('auth:api')->get('/mark-as-seen/{id}', 'HomeController@markAsSeen')->name('markAsSeen');
Route::middleware('auth:api')->get('/catch-ticket-messages', 'HomeController@catchTicketMessage')->name('catchTicketMessage');
