<?php

class BaseController extends Controller {

	// 用于说明未定义的数据项
	const UNDEFINED_ITEM = 'UNDEFINED';

	// 用于绑定到视图的数据项
	protected $data;

	public function __construct()
	{
		$this->data = array(
			'title' 		=> self::UNDEFINED_ITEM,
			'pageTag' 		=> self::UNDEFINED_ITEM,
			'headerTitle' 	=> self::UNDEFINED_ITEM,
			'headerSubtext' => self::UNDEFINED_ITEM
		 );
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
