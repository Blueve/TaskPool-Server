<?php

class HomeController extends BaseController {

	public function startup()
	{
		$this->MergeData(Lang::get('base.startup'));
		$this->SetPageTag('home');
		return View::make('home.startup', $this->data);
	}

}