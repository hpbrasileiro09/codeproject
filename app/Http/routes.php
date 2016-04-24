<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');
Route::put('client/{id}', 'ClientController@update');

Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
Route::post('project/{id}/note', 'ProjectNoteController@store');
Route::get('project/{id}/note', 'ProjectNoteController@index');
Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');
Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');

Route::get('project/{id}/task/{taskId}', 'ProjectTaskController@show');
Route::post('project/{id}/task', 'ProjectTaskController@store');
Route::get('project/{id}/task', 'ProjectTaskController@index');
Route::put('project/{id}/task/{taskId}', 'ProjectTaskController@update');
Route::delete('project/{id}/task/{taskId}', 'ProjectTaskController@destroy');

Route::get('project/{id}/member/{memberId}', 'ProjectMemberController@show');
Route::get('project/{id}/member', 'ProjectMemberController@index');
Route::put('project/{id}/member/{memberId}', 'ProjectMemberController@update');
Route::post('project/{id}/member', 'ProjectMemberController@store');
Route::delete('project/{id}/member/{memberId}', 'ProjectMemberController@destroy');

Route::get('project/{id}/members', 'ProjectMemberController@index');
Route::get('project/{id}/user/{userId}', 'ProjectController@addMember');
Route::get('project/{id}/member/{memberId}/remove', 'ProjectController@removeMember');
Route::get('project/{id}/user/{userId}/is', 'ProjectController@isMember');

Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::put('project/{id}', 'ProjectController@update');
