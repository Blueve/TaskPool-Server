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

Route::controller('/', 'HomeController');


// 以下路由只允许游客访问
Route::group(array('before' => 'guest'), function()
{

	Route::post('signin', 'AccountController@signin_post');
	Route::post('signup', 'AccountController@signup_post');
});

// 以下路由只允许登录的用户访问
Route::group(array('before' => 'auth'), function()
{
	Route::get('signout', 'AccountController@signout');
});

// 以下路由只允许登录且未通过验证的用户访问
Route::group(array('before' => 'auth|unconfirmed'), function()
{
	Route::get('unconfirmed', 'AccountController@unconfirm');
});

// 以下路由允许任何访客访问
Route::get('findpassword/{userId?}/{checkcode?}', 'AccountController@findPassword');
Route::post('findpassword', 'AccountController@findPassword_post');
Route::post('setnewpassword', 'AccountController@setNewPassword_post');

Route::get('confirm/{userId}/{checkCode}', 'AccountController@confirm');
Route::get('reconfirm/{userId?}/{checkCode?}', 'AccountController@reconfirm');

// 以下路由只允许通过邮箱验证的登陆的用户访问
Route::group(array('before' => 'auth|confirmed'), function()
{
	Route::get('user', 'UserController@home');

	Route::get('user/setting', 'UserController@setting');
	Route::post('user/setting', 'UserController@setting_post');

	// JSON
	Route::post('list/create', 'ListController@create_post');
	// HTML
	Route::post('list/content', 'ListController@content_post');
	// JSON
	Route::post('list/reorder', 'ListController@reorder_post');
	// JSON
	Route::post('list/updateListSetting', 'ListController@updateListSetting_post');
	// JSON
	Route::post('list/delete/{listId}', 'ListController@delete_post');
	// JSON
	Route::get('list/getListSetting/{listId}', 'ListController@getListSetting');
});