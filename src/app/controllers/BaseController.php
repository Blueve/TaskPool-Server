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

	/**
	 * 将指定的数据并入视图数据集中
	 * 
	 * @param  array $arr 数据集
	 * @return void
	 */
	protected function MergeData($arr)
	{
		$this->data = array_merge($this->data, $arr);
	}

	/**
	 * 设置页面的Tag
	 *
	 * 设置页面Tag后，在视图中，若与指定Tag匹配，则会按照视图
	 * 的设定增加额外的显示效果，例如导航栏选中的效果
	 * 
	 * @param  string $tagName Tag
	 * @return void
	 */
	protected function SetPageTag($tagName)
	{
		$this->data['pageTag'] = $tagName;
	}

	/**
	 * 返回一个提示页面
	 * 
	 * @param  string $pageLang   页面基本信息对应的语言包空间
	 * @param  string $type       提示类型：success\danger\warning\info
	 * @param  string $notice     提示内容对应的语言包空间
	 * @param  string $route      跳转目标Route
	 * @param  array  $routeValue 跳转目标Route附加串
	 * @return View               提示页面
	 */
	protected function NoticeResponse($pageLang, $type, $notice, $route = '/', $routeValue = array())
	{
		$notice = new Notice($type, $notice, $route, $routeValue);
		$this->MergeData(Lang::get($pageLang));
		$this->MergeData($notice->getData());
		return View::make('common.notice', $this->data);
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}