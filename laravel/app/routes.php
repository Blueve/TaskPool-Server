<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@startup');

Route::post('signin', 'UserController@signin');

Route::post('signup', 'UserController@signup');

Route::get('signout', 'UserController@signout');

Route::get('user/confirm/{userId}/{checkCode}', 'UserController@confirm');

Route::get('user/reconfirm/{userId}/{checkCode}', 'UserController@reconfirm');

Route::group(array('before' => 'auth'), function()
{
	Route::get('user/unconfirmed', 'UserCOntroller@unconfirm');
})

Route::group(array('before' => 'auth|confirmed'), function()
{
	Route::get('user/edit', 'UserController@edit');

	Route::post('user/edit', 'UserController@edit_post');
});