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
Route::controller('account', 'AccountController');


// 以下路由只允许通过邮箱验证的登陆的用户访问
Route::group(array('before' => 'auth|confirmed'), function()
{
	Route::controller('user', 'UserController');


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

Route::controller('', 'HomeController');