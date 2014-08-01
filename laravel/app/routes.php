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


// 以下路由只允许游客访问
Route::group(array('before' => 'guest'), function()
{
	Route::get('/', 'HomeController@startup');

	Route::post('signin', 'AccountController@signin');
	Route::post('signup', 'AccountController@signup');
});

// 以下路由只允许登录的用户访问
Route::group(array('before' => 'auth'), function()
{
	Route::get('signout', 'AccountController@signout');
	Route::get('unconfirmed', 'AccountController@unconfirm');
});

// 以下路由允许任何访客访问
Route::get('findpassword/{userId?}/{checkcode?}', 'AccountController@findpassword');
Route::post('findpassword', 'AccountController@findpassword_post');
Route::post('setnewpassword', 'AccountController@setnewpassword');

Route::get('confirm/{userId}/{checkCode}', 'AccountController@confirm');
Route::get('reconfirm/{userId?}/{checkCode?}', 'AccountController@reconfirm');

// 以下路由只允许通过邮箱验证的登陆的用户访问
Route::group(array('before' => 'auth|confirmed'), function()
{
	Route::get('user', 'UserController@home');

	Route::get('user/setting', 'UserController@setting');
	Route::post('user/setting', 'UserController@setting_post');

	Route::post('list/create', 'ListController@create');
	Route::post('list/content', 'ListController@content');
	Route::post('list/reorder', 'ListController@reorder');
	route::post('list/getListSetting', 'ListController@getListSetting');
});