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
	//return view('welcome');
	return view("master");
});


Route::get('/videosuploader', 'VideosController@inspectauth');


Route::get('/videosuploaderinternal', function () {
	return view("partials.uploader-form-internal");
});

Route::get('/videosuploaded', 'VideosController@vidlist');


//for handling ajax requests
Route::get('/videolikeajax', 'VideosController@videolikeajax');

Route::get('/videounlikeajax', 'VideosController@videounlikeajax');

/*
Route::get('user/{id}', function ($id) {
	return view("user", ['user' => $id]);
});*/

Route::get('/user/{id}', 'UserController@getUser');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/uploadvideo', 'VideosController@upload');

Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
