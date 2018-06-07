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
	return view("home");
});

Route::get('/home', 'HomeController@index')->name('home');


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

Route::get('/logout', function(){
	return redirect()->route('home');
});

Route::get('/registered', function () {
	//return view('welcome');

	$haystack = Request::server('HTTP_REFERER');
	$needle = env('APP_URL') . "register";

	if( strstr($haystack, $needle) ){
		return view("email.verification");
	}else{
		return redirect()->route('home');
	}
})->name('registered');


Route::post('/uploadvideo', 'VideosController@upload');

Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
