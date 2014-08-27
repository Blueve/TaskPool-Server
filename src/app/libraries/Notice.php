<?php

class Notice{

	private $data;

	const success = "success";
	const info    = "info";
	const warning = "warning";
	const danger  = "danger";

	public function __construct($type, $notice, $route = '/', $routeValue = array())
	{
		if(isset($notice['data']))
		{
			$noticeTitle = $notice['title'];
			$noticeData  = $notice['data'];
		}
		else
		{
			$noticeTitle = $notice;
			$noticeData  = array();
		}
		$this->data = array(
				'noticeType'       => $type,
				'noticeTitle'      => Lang::get('notice.'.$noticeTitle.'.title', $noticeData),
				'noticeContent'    => Lang::get('notice.'.$noticeTitle.'.content', $noticeData),
				'noticeRoute'      => $route,
				'noticeRouteValue' => $routeValue,
			);

	}

	public function getData()
	{
		return $this->data;
	}
}