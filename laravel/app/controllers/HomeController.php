<?php

class HomeController extends BaseController {

	public function startup()
	{
		$this->data['headerTitle'] = '欢迎';
		$this->data['headerSubtext'] = 'Signin or Signup';
		$this->data['title'] = '首页';
		$this->data['pageTag'] = 'home';
		return View::make('home.startup', $this->data);
	}

}