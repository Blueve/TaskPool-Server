<?php

class HomeController extends BaseController
{
	/**
	 * 首页
	 *
	 * 包含了注册/登录界面，可以引导用户进行找回密码等操作
	 * 
	 * @return View 页面
	 */
	public function startup()
	{
		$this->MergeData(Lang::get('base.startup'));
		$this->SetPageTag('home');
		return View::make('home.startup', $this->data);
	}

}