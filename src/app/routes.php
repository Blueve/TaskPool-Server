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
	Route::controller('list', 'ListController');
});

Route::controller('', 'HomeController');