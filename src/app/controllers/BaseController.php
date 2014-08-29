<?php

class BaseController extends Controller 
{

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

	protected function MergeData($arr)
	{
		$this->data = array_merge($this->data, $arr);
	}

	protected function SetPageTag($tagName)
	{
		$this->data['pageTag'] = $tagName;
	}

	protected function NoticeResponse($pageLang, $type, $notice, $route = '/', $routeValue = array())
	{
		$notice = new Notice($type, $notice, $route, $routeValue);
		$this->MergeData(Lang::get($pageLang));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
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
